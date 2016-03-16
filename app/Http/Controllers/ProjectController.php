<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Site;
use App\Page;
use App\Translate;

class ProjectController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
    }

    /**
     * Вывод формы добавления проекта
     * @return \Illuminate\Http\Response
     */
    public function addProject()
    {
        $langs = Language::orderBy('name')->get();
        $languages = [];
        foreach ($langs as $lang) {
            $languages[] = [
                'id' => $lang->id,
                'name'  => $lang->name,
                'src' => '/icons/'.$lang->icon_file,
            ];
        }
        $languages = json_encode($languages);
        return view('project.create', compact('languages'));
    }

    /**
     * Добавление проекта в базу, добавление задач в очередь
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function postAddProject(Request $request)
    {
        $langs = $request->get('language');
        $sourceLang = array_shift($langs);
        $targetLang = array_shift($langs);
        $url = $request->get('url');
        $url = prepareUri($url);
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
            $site = new Site([
                'url'               => $url,
                'name'              => $request->get('name'),
                'user_id'           => $this->user->id,
                'secret'            => str_random(32),
                'language_id'       => $sourceLang,
                'enabled'           => 0,
            ]);
            $site->save();
            $site->languages()->attach($targetLang);
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    if (!$site->hasLanguage($lang)) {
                        $site->languages()->attach($lang);
                    }
                }
            }
            $page = new Page([
                'url'               => $url,
                'site_id'           => $site->id,
                'code'              => 200,
            ]);
            $page->save();
            \DB::table('sites_settings')->insert([
                'site_id'           => $site->id,
                'auto_publishing'   => $request->has('auto_publishing'),
                'auto_translate'    => $request->has('auto_translate')
            ]);
        }
        // TODO change this in ajax
        //return $site->id;
        return redirect()->route('main.account.project-created', ['id' => $site->id]);
    }

    /**
     * Вывод инфы о созданном проекте
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function projectCreated($id)
    {
        $site = Site::find($id);
        if (empty($site) || $site->user_id != $this->user->id) {
            abort(404);
        }
        \Session::set('projectID', $site->id);
        return view('project.created', compact('site'));
    }

    /**
     * Проверка на наличие секрет кея на сайте клиента
     * @param int $id
     * @return string
     */
    public function validateProject($id)
    {
        $site = Site::find($id);
        $content = getPageContent($site->url);
        if (!empty($content) && strpos($content, $site->secret) !== false) {
            $site->enabled = 1;
            $site->save();
            $this->dispatch(new \App\Jobs\Spider($site));
            return 'success';
        }
        return 'fail';
    }

    /**
     * Удаление проекта
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function projectRemove($id)
    {
        $site = Site::find($id);
        if (empty($site) || $site->user_id != $this->user->id) {
            abort(404);
        }
        $site->delete();
        \Session::remove('projectID');
        return redirect()->route('main.account');
    }

    public function languages()
    {
        if (!$siteID = \Session::get('projectID'))  {
            return redirect()-route('main.account.selectProject');
        }
        $site  = Site::find($siteID);
        $langs = Language::where('id', '!=', $site->language_id)->whereNotIn('id', $site->languages()->lists('id')->toArray())->get();
        return view('project.languages', compact('site', 'langs'));
    }

    public function postLanguages(Request $request, $id)
    {
        $site  = Site::find($id);
        $blocks = $site->blocks;
        $blocksIds = $site->blocks()->lists('id', 'id')->toArray();
        $oldLangs = $site->enabledLanguages()->lists('id')->toArray();
        $newLangs = $request->get('languages', []);
        $langsToDel = array_diff($oldLangs, $newLangs);
        $langsToAdd = array_diff($newLangs, $oldLangs);
        foreach ($langsToDel as $l) {
            \DB::table('site_language')->where('site_id', $site->id)->where('language_id', $l)->update(['enabled' => 0]);
            foreach ($site->pages as $page) {
                \Cache::forget($site->secret.'_'.$page->id.'_'.$l);
            }
        }
        foreach ($langsToAdd as $l) {
            if (!$site->hasLanguage($l)) {
                $site->languages()->attach($l);
                foreach ($blocks as $block) {
                    Translate::create([
                        'block_id'      => $block->id,
                        'language_id'   => $l,
                        'text'          => '',
                        'count_words'   => $block->count_words,
                        'site_id'       => $site->id
                    ]);
                }
            } else {
                \DB::table('site_language')->where('site_id', $site->id)->where('language_id', $l)->update(['enabled' => 1]);
            }
        }
        \Event::fire('site.changed', $site);
        return redirect()->back();
    }

}
