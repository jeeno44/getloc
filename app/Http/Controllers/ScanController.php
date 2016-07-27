<?php

namespace App\Http\Controllers;

use App\Block;
use App\Page;
use App\Site;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if ( \Auth::check() && !\App\User::find(\Auth::user()->id)->hasRole('show_stat') )
          {
       
            \Redirect::route('main')->send();
            exit;
          }
    }
    
    public function index(Request $request)
    {
        $newSite = \Session::get('site');
        if (!empty($request->get('search'))) {
            $sites = Site::latest()->where('name', 'like', '%'.$request->get('search').'%')->where('enabled', 1)->paginate(20);
        } else {
            $sites = Site::latest()->where('enabled', 1)->paginate(20);
        }
        $countSites = Site::count();
        $countPages = Page::count();
        $countBlocks = Block::count();
        \Session::remove('site');
        $allSites = Site::all()->pluck('name')->toJson();
        return view('pages.sites', compact('sites', 'countSites', 'countPages', 'countBlocks', 'newSite', 'allSites'));
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
}
