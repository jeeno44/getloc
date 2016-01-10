<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
        $url = rtrim($url, '/');
        $url = str_replace('http://', '', $url);
        $url = 'http://'.$url.'/';
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
            $site = Site::create([
                'url'   => $url,
                'name'  => $url,
                'user_id'   => \Auth::user()->id,
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
        return view('page', compact('page'));
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
}
