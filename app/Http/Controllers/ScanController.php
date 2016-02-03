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
    public function index(Request $request)
    {
        $newSite = \Session::get('site');
        if (!empty($request->get('search'))) {
            $sites = Site::latest()->where('name', 'like', '%'.$request->get('search').'%')->paginate(20);
        } else {
            $sites = Site::latest()->paginate(20);
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
        $pages = $site->pages()->with('blocks')->paginate(20);
        return view('pages.site', compact('site', 'pages'));
    }

    public function page($id)
    {
        $page = Page::find($id);
        $blocks = $page->blocks;
        return view('pages.page', compact('page', 'blocks'));
    }

    public function postSite(Request $request)
    {

    }
}
