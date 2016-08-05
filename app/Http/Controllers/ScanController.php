<?php

namespace App\Http\Controllers;

use App\Block;
use App\Page;
use App\Site;
use App\UserDetail;
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
        $newSite = \Session::get('site');
        if (!empty($request->get('search'))) {
            $sites = Site::latest()->where('user_id', \Auth::user()->id)->where('name', 'like', '%'.$request->get('search').'%')->where('enabled', 1)->paginate(20);
        } else {
            $sites = Site::latest()->where('user_id', \Auth::user()->id)->where('enabled', 1)->paginate(20);
        }
        $countSites = Site::count();
        $countPages = Page::count();
        $countBlocks = Block::count();
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
        $url = prepareUri($url);
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
            $defaultLang = \App\Language::where('short', 'ru')->first();
            $site = new Site([
                'url'           => $url,
                'name'          => $url,
                'user_id'       => \Auth::user()->id,
                'secret'        => str_random(32),
                'language_id'   => $defaultLang->id,
                'demo'          => 1,
            ]);
            $site->save();
            \DB::table('sites_settings')->insert([
                'site_id'           => $site->id,
                'auto_publishing'   => false,
                'auto_translate'    => false
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

        return redirect()->back()->with(['status' => 'Сохранено']);
    }

    public function export($id)
    {
        $site = Site::find($id);
        if (!$site || $site->user_id != \Auth::user()->id) {
            abort(404);
        }
        $exp = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<tmx version=\"1.4\">\n\t<header creationtool=\"getLoc.ru\" creationtoolversion=\"1.2\" segtype=\"sentence\" o-tmf=\"ATM\" adminlang=\"en-US\" srclang=\"ru-RU\" datatype=\"plaintext\" />\n\t\t<body>";
        foreach ($site->blocks as $block) {
            $exp .= "\n\t\t\t<tu>\n\t\t\t\t<tuv xml:lang=\"ru-RU\">\n\t\t\t\t\t<seg>\n".htmlspecialchars(trim($block->text))."\n\t\t\t\t\t</seg>\n\t\t\t\t</tuv>\n\t\t\t</tu>";
        }
        $exp .= "\n\t\t</body>\n\t</tmx>";
        header("Content-type: text/xml");
        header("Content-Disposition: attachment; filename=экспорт {$site->name}.xml");
        echo $exp;
    }
}
