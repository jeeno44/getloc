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
        $targetLang =  /* array_shift($langs); */ true;
        $this->validate($request, [
            'url' => 'required|url',
            'name' => 'required',
        ]);
        if(empty($targetLang) || empty($sourceLang)) {
            return redirect()->back()->withErrors('Выберите языки перевода')->withInput();
        }
        $url = $request->get('url');
        $url = prepareUri($url);
        $site = Site::where('url', $url)->whereNull('deleted_at')->first();
        if (empty($site)) {
            $site = new Site([
                'url'               => rtrim($url, '/'),
                'name'              => $request->get('name'),
                'user_id'           => $this->user->id,
                'secret'            => str_random(32),
                'language_id'       => $sourceLang,
                'enabled'           => 0,
                'protected'         => $request->has('protected'),
                'demo'              => 1
            ]);
            $site->save();
            //$site->languages()->attach($targetLang);
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    if (!$site->hasLanguage($lang) && !empty($lang)) {
                        $site->languages()->attach($lang);
                    }
                }
            }
            \DB::table('sites_settings')->insert([
                'site_id'           => $site->id,
                'auto_publishing'   => $request->has('auto_publishing'),
                'auto_translate'    => /*$request->has('auto_translate')*/ 0
            ]);
            \DB::table('site_state')->insert([
                'site_id'  => $site->id,
                'status'   => 'Сайт добавлен'
            ]);
            \DB::table('widgets')->insert([
                'site_id' => $site->id
            ]);
            
        } else {
            return redirect()->back()->withErrors('Сайт с таким адресом уже существует в системе')->withInput();
        }
        \Event::fire('site.start', $site);
        // TODO change this in ajax
        //return $site->id;
        //return redirect()->route('main.account.project-created', ['id' => $site->id]);
        return redirect()->route('main.account.selectProject');
    }

    /**
     * Вывод инфы о созданном проекте
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function projectCreated($id)
    {
        
        $site = Site::find($id);
        if (empty($site)) {
            abort(404);
        }
        if ($site->user_id != $this->user->id) {
            abort(403, 'Сайт добавлен другим пользователем');
        }
        \Session::set('projectID', $site->id);
        \Event::fire('site.start', $site); // TODO продумать проверку вставки кода
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
        if ((!empty($content) && strpos($content, $site->secret) !== false) || $this->user->hasRole('admin')) {
            $site->enabled = 1;
            $site->save();
            //$this->dispatch(new \App\Jobs\Spider($site));
            //\Event::fire('site.start', $site);
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
        return redirect()->back()->with('msg', ['class' => 'info-massages__item_deleted', 'text' => 'Проект успешно удален']);
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
        //$blocksIds = $site->blocks()->lists('id', 'id')->toArray();
        $oldLangs = $site->enabledLanguages()->lists('id')->toArray();
        $newLangs = $request->get('languages', []);
        //$langsToDel = array_diff($oldLangs, $newLangs);
        $langsToAdd = array_diff($newLangs, $oldLangs);
        /*foreach ($langsToDel as $l) {
            \DB::table('site_language')->where('site_id', $site->id)->where('language_id', $l)->update(['enabled' => 0]);
            foreach ($site->pages as $page) {
                \Cache::forget($site->secret.'_'.$page->id.'_'.$l);
                TODO новое кеширование
            }
        }*/
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
        return redirect()->back()->with('msg', ['class' => 'info-massages__item_detected', 'text' => 'Выбранные языки успешно добавлены']);
    }

    public function deleteLanguages($siteID, $languageID)
    {
        $site = Site::find($siteID);
        if (!$site || $site->user_id != $this->user->id) {
            abort(404);
        }
        \DB::table('site_language')->where('site_id', $siteID)->where('language_id', $languageID)->delete();
        \DB::table('translates')->where('site_id', $siteID)->where('language_id', $languageID)->delete();
        return redirect()->back()->with('msg', ['class' => 'info-massages__item_deleted', 'text' => 'Язык и все переведенные фразы удалены']);
    }

    public function collect()
    {
        $siteID     = \Session::get('projectID');
        $site       = Site::find($siteID);
        if (empty($site)) {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
        }
        $pages = $site->pages()->paginate(20);
        foreach ($pages as $key => $page) {
            $pages[$key] = \Cache::remember('page_'.$page->id, 60 * 24 * 30, function() use ($page) {
                $page->count_blocks = $page->blocks()->count();
                $page->count_words = $page->blocks()->sum('count_words');
                $page->count_symbs = $page->blocks()->sum('count_symbols');
                return $page;
            });
        }
        return view('account.demo_pages', compact('sites', 'site', 'pages'));
    }

    public function collectPage($id)
    {
        $siteID     = \Session::get('projectID');
        $site       = Site::find($siteID);
        if (empty($site)) {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
        }
        $page = Page::find($id);
        $blocks = $page->blocks;
        return view('account.demo_page', compact('page', 'blocks'));
    }

    public function build()
    {
        $sites = Site::where('user_id', \Auth::user()->id)->where('demo', 1)->get();
        return view('account.build', compact('sites'));
    }

    public function buildStore(Request $request)
    {
        if ($request->has('sites')) {
            //TODO переделать! сделать очередями, а то при большом колличестве сайтов упадет ошибка
            foreach ($request->get('sites') as $id) {
                $site  = Site::find($id);
                $blocks = $site->blocks;
                $langId = 1; // english
                $site->languages()->attach($langId);
                foreach ($blocks as $block) {
                    Translate::create([
                        'block_id'      => $block->id,
                        'language_id'   => $langId,
                        'text'          => '',
                        'count_words'   => $block->count_words,
                        'site_id'       => $site->id
                    ]);
                }
                $site->demo = 0;
                $site->save();
            }
            return redirect()->route('main.account.selectProject')
                ->with('msg',
                    ['class' => 'info-massages__item_detected', 'text' => 'Сайты добавлены в очередь на создание локализации']
                );
        } else {
            return redirect()->back()->withErrors('Не выбрано ни одного проекта');
        }
    }

}
