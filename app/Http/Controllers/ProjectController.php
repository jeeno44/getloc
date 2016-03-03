<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Site;
use App\Page;

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
        $langs = Language::all();
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
                'url'   => $url,
                'name'  => $request->get('name'),
                'user_id'   => $this->user->id,
                'secret'    => str_random(32),
                'language_id'   => $sourceLang,
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
                'url'       => $url,
                'site_id'   => $site->id,
                'code'      => 200,
            ]);
            $page->save();
        }
        $this->dispatch(new \App\Jobs\Spider($site));
        return $site->id;
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
        return view('project.created', compact('site'));
    }

    public function languages()
    {

    }

}
