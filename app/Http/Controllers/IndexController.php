<?php

namespace App\Http\Controllers;

use App\Page;
use App\Site;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex()
    {
        $sites = Site::with('pages')->get();
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
            ]);
            Page::create([
                'url'       => $url,
                'site_id'   => $site->id,
                'code'      => 200,
            ]);
        }
        $this->dispatch(new \App\Jobs\Spider($site));
        return redirect('site/'.$site->id);
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
}
