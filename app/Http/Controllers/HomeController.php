<?php

namespace App\Http\Controllers;

use App\Block;
use App\Http\Requests;
use App\Language;
use App\Translate;
use Illuminate\Http\Request;
use App\Site;
use App\Page;

class HomeController extends Controller
{
    public function index()
    {
        $sites = Site::with('pages')->where('user_id', \Auth::user()->id)->latest()->get();
        return view('sites', compact('sites'));
    }

    public function postIndex(Request $request)
    {
        $url = $request->get('url');
        $url = prepareUri($url);
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
            $defaultLang = Language::where('short', 'ru')->first();
            $site = Site::create([
                'url'   => $url,
                'name'  => $url,
                'user_id'   => \Auth::user()->id,
                'secret'    => str_random(32),
                'language_id'   => $defaultLang->id,
            ]);
            Page::create([
                'url'       => $url,
                'site_id'   => $site->id,
                'code'      => 200,
            ]);
        }
        $this->dispatch(new \App\Jobs\Spider($site));
        return redirect('/home/site/'.$site->id);
    }

    public function getSite($id)
    {
        $site = Site::find($id);
        $pages = $site->pages()->with('blocks')->paginate(20);
        return view('site', compact('site', 'pages'));
    }

    public function getPage($id)
    {
        $page = Page::find($id);
        $langs = $page->site->languages()->lists('name', 'short')->toArray();
        $langs[''] = "Выберите язык перевода";
        ksort($langs, SORT_STRING);
        if (!empty(\Input::get('lang'))) {
            $lang = Language::where('short', \Input::get('lang'))->first();
            $blocks = $page->blocks()->join('translates', 'blocks.id', '=', 'translates.block_id')
                ->where('translates.language_id', $lang->id)
                ->select('blocks.text', 'translates.id as tid', 'translates.text as ttext')
                ->get();
        } else {
            $blocks = $page->blocks;
        }

        return view('page', compact('page', 'langs', 'lang', 'blocks'));
    }

    public function getDeleteSite($id)
    {
        $site = Site::find($id);
        if (!empty($site) && $site->user_id == \Auth::user()->id) {
            $site->delete();
            return redirect()->back();
        }
        abort(404);
    }

    public function getEditSite($id)
    {
        $site = Site::find($id);
        $langs = Language::where('id', '!=', $site->language_id)->get();
        return view('sites.edit', compact('site', 'langs'));
    }

    public function postEditSite($id, Request $request)
    {
        $site = Site::find($id);
        $blocks = $site->blocks()->lists('id', 'id')->toArray();
        $oldLangs = $site->languages()->lists('id')->toArray();
        $newLangs = $request->get('languages', []);
        $langsToDel = array_diff($oldLangs, $newLangs);
        $langstoAdd = array_diff($newLangs, $oldLangs);
        foreach ($langsToDel as $l) {
            \DB::table('site_language')->where('site_id', $site->id)->where('language_id', $l)->delete();
            \DB::table('translates')->whereIn('block_id', $blocks)->where('language_id', $l)->delete();
            foreach ($site->pages as $page) {
                \Cache::forget($site->secret.'_'.$page->id.'_'.$l);
            }
        }
        foreach ($langstoAdd as $l) {
            if (!$site->hasLanguage($l)) {
                $site->languages()->attach($l);
                foreach ($blocks as $block) {
                    Translate::create([
                        'block_id'  => $block,
                        'language_id'   => $l,
                        'text'  => '',
                    ]);
                }
            }
        }
        return redirect()->back();
    }
}
