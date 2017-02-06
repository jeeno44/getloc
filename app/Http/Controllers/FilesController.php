<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Site;
use App\SiteFile;
use Session;

class FilesController extends Controller
{
    private $sites = [];

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get();
        \View::share('sites', $this->sites);
    }

    public function images()
    {
        $siteID     = Session::get('projectID');
        $site       = Site::find($siteID);
        if (!$site || $site->user_id != $this->user->id) {
            Session::remove('projectID');
            return redirect()->route('main.account.selectProject');
        }
        $startUrl = $site->url;
        $files = SiteFile::where('site_id', $siteID)->where('full_url', 'LIKE', $startUrl.'%')->where('ftype', 'image')->paginate(25);
//        dd($files);
        return view('files.images', compact('files'));
    }

    public function docs()
    {
        $siteID     = Session::get('projectID');
        $site       = Site::find($siteID);
        if (!$site || $site->user_id != $this->user->id) {
            Session::remove('projectID');
            return redirect()->route('main.account.selectProject');
        }
        $startUrl = $site->url;
        $files = SiteFile::where('site_id', $siteID)->where('full_url', 'LIKE', $startUrl.'%')->where('ftype', 'doc')->paginate(25);
        return view('files.docs', compact('files'));
    }
}
