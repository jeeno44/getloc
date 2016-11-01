<?php

namespace App\Http\Controllers;

use App\Block;
use App\Page;
use App\Site;
use App\UserDetail;
use App\Language;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function __construct()
    {
        parent::__construct();

//        if ( \Auth::check() && !\App\User::find(\Auth::user()->id)->hasRole('show_stat') )
//          {
//
//            \Redirect::route('main')->send();
//            exit;
//          }
    }

    public function index(Request $request)
    {
        $langs = Language::orderBy('sort')->get();
        $languages = [];
        foreach ($langs as $lang) {
            $languages[] = [
                'id' => $lang->id,
                'name'  => $lang->name,
                'src' => '/icons/'.$lang->icon_file,
            ];
        }
        $languages = json_encode($languages);

        $newSite = \Session::get('site');
        if (!empty($request->get('search'))) {
            $siteIds = Site::latest()->where('user_id', \Auth::user()->id)->where('name', 'like', '%'.$request->get('search').'%')->lists('id')->toArray();
            $sites = Site::latest()->where('user_id', \Auth::user()->id)->where('name', 'like', '%'.$request->get('search').'%')->paginate(20);
        } else {
            $sites = Site::latest()->where('user_id', \Auth::user()->id)->paginate(20);
            $siteIds = Site::latest()->where('user_id', \Auth::user()->id)->lists('id')->toArray();
        }
        $countSites = $sites->total();
        $countPages = Page::whereIn('site_id', $siteIds)->count();
        $countBlocks = Block::whereIn('site_id', $siteIds)->count();
        \Session::remove('site');
        $allSites = Site::where('user_id', \Auth::user()->id)->pluck('name')->toJson();
        $details = UserDetail::where('user_id', \Auth::user()->id)->first();
        return view('pages.sites', compact('sites', 'countSites', 'countPages', 'countBlocks', 'newSite', 'allSites', 'details'));
    }

    public function site($id)
    {
        $site = Site::find($id);
        $pages = $site->pages()->paginate(20);
        foreach ($pages as $key => $page) {
            $pages[$key] = \Cache::remember('page_'.$page->id, 60 * 24 * 30, function() use ($page) {
                $page->count_blocks = $page->blocks()->count();
                $page->count_words = $page->blocks()->sum('count_words');
                $page->count_symbs = $page->blocks()->sum('count_symbols');
                return $page;
            });
        }
        return view('pages.site', compact('site', 'pages'));
    }

    public function page($id)
    {
        $page = Page::find($id);
        $blocks = $page->blocks;
        return view('pages.page', compact('page', 'blocks'));
    }

    public function anySites(Request $request)
    {
        $term = $request->get('term');
        $sites = Site::where('url', 'like', '%'.$term.'%')->get()->pluck('name', 'id')->toArray();
        foreach($sites as $id => $site) {
            $sites[$id] = ['key' => $id, 'value' => beautyUrl($site)];
        }
        return \Response::json($sites);
    }

    public function getDemo(Request $request)
    {
        $url = $request->get('url');
        $lang = $request->get('lang');
        $url = prepareUri($url);
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
	    if (empty($lang)) {
                $defaultLang = \App\Language::where('short', 'ru')->first();
	    } else {
                $defaultLang = \App\Language::where('id', $lang)->first();
	    }
            $site = new Site([
                'url'           => $url,
                'name'          => $url,
                'user_id'       => \Auth::user()->id,
                'secret'        => str_random(32),
                'language_id'   => $defaultLang->id,
                'demo'          => 1,
            ]);
            $site->save();
            $site->languages()->attach(1);
            \DB::table('sites_settings')->insert([
                'site_id'           => $site->id,
                'auto_publishing'   => false,
                'auto_translate'    => false
            ]);
            \DB::table('site_state')->insert([
                'site_id'  => $site->id,
                'status'   => 'Сайт добавлен'
            ]);
        }
        \Event::fire('site.start', $site);
        return redirect()->back();
    }

    public function contragent()
    {
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $detail = new UserDetail();
        }
        return view('scan.details-form', compact('detail'));
    }

    public function detailsStore(Request $request)
    {
        $data = $request->all();
        $detail = UserDetail::where('user_id', $this->user->id)->first();
        if (!$detail) {
            $data['user_id'] = $this->user->id;
            $detail = new UserDetail($data);
        }
        $detail->fill($data);
        $detail->save();
        \Mail::send('emails.details-store', ['detail' => $detail], function ($m) {
            $m->to(['vchevela@gmail.com', 'a@lezhnin.me'])->subject('Изменены данные контрагента!');
        });
        return redirect()->back()->with(['status' => 'Сохранено']);
    }

    public function tmxexport($id, $pageID = null, Request $request) {
        $lang1 = Language::where('id', $request->get('lang1'))->first();
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        if (!empty($pageID)) {
            $page = Page::find($pageID);
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<tmx version=\"1.4\">\n\t<header creationtool=\"getLoc.ru\" creationtoolversion=\"1.2\" segtype=\"sentence\" o-tmf=\"ATM\" adminlang=\"en-US\" srclang=\"".$lang1->export."\" datatype=\"plaintext\" />\n\t\t<body>";
            foreach ($page->blocks as $block) {
                $exp .= "\n\t\t\t<tu>\n\t\t\t\t<tuv xml:lang=\"".$lang1->export."\">\n\t\t\t\t\t<seg>\n\t\t\t\t\t\t".htmlspecialchars(trim($block->text))."\n\t\t\t\t\t</seg>\n\t\t\t\t</tuv>\n\t\t\t</tu>";
            }
            $exp .= "\n\t\t</body>\n\t</tmx>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-{$page->url}-export.xml");
        } else {
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<tmx version=\"1.4\">\n\t<header creationtool=\"getLoc.ru\" creationtoolversion=\"1.2\" segtype=\"sentence\" o-tmf=\"ATM\" adminlang=\"en-US\" srclang=\"".$lang1->export."\" datatype=\"plaintext\" />\n\t\t<body>";
            foreach ($site->blocks as $block) {
                $exp .= "\n\t\t\t<tu>\n\t\t\t\t<tuv xml:lang=\"".$lang1->export."\">\n\t\t\t\t\t<seg>\n\t\t\t\t\t\t".htmlspecialchars(trim($block->text))."\n\t\t\t\t\t</seg>\n\t\t\t\t</tuv>\n\t\t\t</tu>";
            }
            $exp .= "\n\t\t</body>\n\t</tmx>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-export.xml");
        }

        echo $exp;
    }

    public function xlfexport($id, $pageID = null, Request $request)
    {
        $lang1 = Language::where('id', $request->get('lang1'))->first();
        $lang2 = Language::where('id', $request->get('lang2'))->first();
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        if (!empty($pageID)) {
            $page = Page::find($pageID);
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"".$lang1->export."\" target-language=\"".$lang2->export."\">\n\t\t<header></header>\n\t\t\t<body>";
            foreach ($page->blocks as $block) {
                $exp .= "\n\t\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-{$page->url}-export.xlf");
        } else {
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"".$lang1->export."\" target-language=\"".$lang2->export."\">\n\t\t<header></header>\n\t\t<body>";
            foreach ($site->blocks as $block) {
                $exp .= "\n\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-export.xlf");
        }


        echo $exp;
    }


    public function export($id, $pageID = null)
    {
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        if (!empty($pageID)) {
            $page = Page::find($pageID);
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<tmx version=\"1.4\">\n\t<header creationtool=\"getLoc.ru\" creationtoolversion=\"1.2\" segtype=\"sentence\" o-tmf=\"ATM\" adminlang=\"en-US\" srclang=\"ru-RU\" datatype=\"plaintext\" />\n\t\t<body>";
            foreach ($page->blocks as $block) {
                $exp .= "\n\t\t\t<tu>\n\t\t\t\t<tuv xml:lang=\"ru-RU\">\n\t\t\t\t\t<seg>\n\t\t\t\t\t\t".htmlspecialchars(trim($block->text))."\n\t\t\t\t\t</seg>\n\t\t\t\t</tuv>\n\t\t\t</tu>";
            }
            $exp .= "\n\t\t</body>\n\t</tmx>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-{$page->url}-export.xml");
        } else {
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<tmx version=\"1.4\">\n\t<header creationtool=\"getLoc.ru\" creationtoolversion=\"1.2\" segtype=\"sentence\" o-tmf=\"ATM\" adminlang=\"en-US\" srclang=\"ru-RU\" datatype=\"plaintext\" />\n\t\t<body>";
            foreach ($site->blocks as $block) {
                $exp .= "\n\t\t\t<tu>\n\t\t\t\t<tuv xml:lang=\"ru-RU\">\n\t\t\t\t\t<seg>\n\t\t\t\t\t\t".htmlspecialchars(trim($block->text))."\n\t\t\t\t\t</seg>\n\t\t\t\t</tuv>\n\t\t\t</tu>";
            }
            $exp .= "\n\t\t</body>\n\t</tmx>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-export.xml");
        }

        echo $exp;
    }

    public function xliff($id, $pageID = null)
    {
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        if (!empty($pageID)) {
            $page = Page::find($pageID);
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"ru-RU\" target-language=\"en\">\n\t\t<header></header>\n\t\t\t<body>";
            foreach ($page->blocks as $block) {
                $exp .= "\n\t\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-{$page->url}-export.xlf");
        } else {
            $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<xliff>\n\t<file original=\"\" source-language=\"ru-RU\" target-language=\"en\" target-language=\"ru\">\n\t\t<header></header>\n\t\t<body>";
            foreach ($site->blocks as $block) {
                $exp .= "\n\t\t\t<trans-unit id=\"{$block->id}\">\n\t\t\t\t<source>".htmlspecialchars(trim($block->text))."</source>\n\t\t\t</trans-unit>";
            }
            $exp .= "\n\t\t</body>\n\t</file>\n</xliff>";
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename={$site->name}-export.xlf");
        }


        echo $exp;
    }

    public function delete($id)
    {
        $site = Site::find($id);
        if (empty($site) || $site->user_id != $this->user->id) {
            abort(404);
        }
        \DB::table('sites')->where('id', $id)->delete();
        \Session::remove('projectID');
        return redirect()->back()->with('msg', ['class' => 'info-massages__item_deleted', 'text' => 'Проект успешно удален']);
    }
}
