<?php

namespace App\Http\Controllers;

use App\DocTranslate;
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
        $this->scripts[] = '/assets/js/account/docs.js';
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
        $files = SiteFile::where('site_id', $siteID)->where('ftype', 'image')->paginate(20);
        if ($site->languages()->count()) {
            $langs = [];
            foreach ($site->languages as $lang) {
                $countTransDocs = DocTranslate::where('site_id', $site->id)->where('language_id', $lang->id)->count();
                $countDocs = SiteFile::where('site_id', $siteID)->whereNull('deleted_at')->count();
                if ($countDocs != $countTransDocs) {
                    $this->createTrans($site, $lang);
                }
                $langs[$lang->id] = [
                    'name' => $lang->name,
                    'id'   => $lang->id,
                    'icon_file' => $lang->icon_file,
                    'count_trans' => DocTranslate::where('site_id', $site->id)->where('language_id', $lang->id)->where('ftype', 'image')->where('full_url', '!=', '')->count(),
                    'count_docs' => SiteFile::where('site_id', $siteID)->where('ftype', 'image')->count(),
                ];
            }
            $arch = \DB::table('docs_sites')->whereNotNull('deleted_at')->count();
            return view('files.images-filter', compact('files', 'langs', 'arch', 'site'));
        }
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
        $files = SiteFile::where('site_id', $siteID)->where('ftype', 'doc')->paginate(20);
        if ($site->languages()->count()) {
            $langs = [];
            foreach ($site->languages as $lang) {
                $countTransDocs = DocTranslate::where('site_id', $site->id)->where('language_id', $lang->id)->count();
                $countDocs = SiteFile::where('site_id', $siteID)->whereNull('deleted_at')->count();
                if ($countDocs != $countTransDocs) {
                    $this->createTrans($site, $lang);
                }
                $langs[$lang->id] = [
                    'name' => $lang->name,
                    'id'   => $lang->id,
                    'icon_file' => $lang->icon_file,
                    'count_trans' => DocTranslate::where('site_id', $site->id)->where('language_id', $lang->id)->where('ftype', 'doc')->where('full_url', '!=', '')->count(),
                    'count_docs' => SiteFile::where('site_id', $siteID)->where('ftype', 'doc')->count(),
                ];
            }
            $arch = \DB::table('docs_sites')->whereNotNull('deleted_at')->count();
            return view('files.docs-filter', compact('files', 'langs', 'arch', 'site'));
        }
        return view('files.docs', compact('files'));
    }

    /**
     * @param \App\Site $site
     * @param \App\Language $lang
     */
    protected function createTrans($site, $lang)
    {
        foreach (SiteFile::where('site_id', $site->id)->get() as $doc) {
            $dt = DocTranslate::where('doc_id', $doc->id)->where('language_id', $lang->id)->first();
            if (!$dt) {
                DocTranslate::create([
                    'site_id' => $site->id,
                    'doc_id'  => $doc->id,
                    'language_id' => $lang->id,
                    'ftype' => $doc->ftype,
                ]);
            }
        }
    }

    function archive($id)
    {
        $doc = \DB::table('docs_sites')->find($id);
        if ($doc) {
            if (empty($doc->deleted_at)) {
                \DB::table('docs_sites')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            } else {
                \DB::table('docs_sites')->where('id', $id)->update(['deleted_at' => null]);
            }
        }
        return 'true';
    }

    public function save(Request $request, $id)
    {
        $dt = DocTranslate::find($id);
        if ($dt) {
            $dt->full_url = $request->get('text');
            $dt->save();
        }
        return 'true';
    }

    public function upload(Request $request, $id)
    {
        $dt = DocTranslate::find($id);
        if ($dt) {
            if ($request->hasFile('file')) {
                $fname = str_random(16).'.'.$request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(public_path('uploads'), $fname);
                $dt->full_url = asset('uploads/'.$fname);
                $dt->save();
            }
        }
        return 'true';
    }

    function filterImages(Request $request) {
        $site = Site::find($request->get('site_id'));
        if ($request->get('lang') == 'arch') {
            $buildQuery = DocTranslate::where('doc_translates.site_id', $request->get('site_id'))
                ->where('doc_translates.ftype', 'image')
                ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                ->groupBy('docs_sites.id')
                ->whereNotNull('docs_sites.deleted_at');
            if ($request->has('pages') && count($request->get('pages')) > 0 ) {
                $buildQuery->leftJoin('page_doc', 'page_doc.doc_id', '=', 'docs_sites.id')
                    ->leftJoin('pages', 'pages.id', '=', 'page_doc.page_id')
                    ->whereIn('pages.url', $request->get('pages'))
                    ->where('pages.enabled', '=', 1);
            }
        } else {
            $buildQuery = DocTranslate::where('doc_translates.site_id', $request->get('site_id'))
                ->where('doc_translates.language_id', $request->get('lang'))
                ->where('doc_translates.ftype', 'image')
                ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                ->whereNull('docs_sites.deleted_at');
            if ($request->has('pages') && count($request->get('pages')) > 0 ) {
                $buildQuery->leftJoin('page_doc', 'page_doc.doc_id', '=', 'docs_sites.id')
                    ->leftJoin('pages', 'pages.id', '=', 'page_doc.page_id')
                    ->whereIn('pages.url', $request->get('pages'))
                    ->where('pages.enabled', '=', 1);
            }
        }
        $buildQuery->select('doc_translates.id as id',  'docs_sites.full_url as original_url',
            'doc_translates.full_url as trans_url', 'doc_translates.doc_id as doc_id', 'docs_sites.deleted_at as deleted_at');
        $files = $buildQuery->paginate(20);
        $arch = \DB::table('docs_sites')->whereNotNull('deleted_at')->where('ftype', 'image')->count();
        $langs = [];
        foreach ($site->languages as $lang) {
            $langs[$lang->id] = [
                'id'   => $lang->id,
                'count_trans' => DocTranslate::where('doc_translates.site_id', $site->id)->where('language_id', $lang->id)
                    ->where('doc_translates.ftype', 'image')->where('doc_translates.full_url', '!=', '')
                    ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                    ->whereNull('docs_sites.deleted_at')
                    ->count(),
                'count_docs' => SiteFile::where('site_id', $site->id)->whereNull('deleted_at')->where('ftype', 'image')->count(),
            ];
        }
        return \Response::json([
            'arch' => $arch,
            'langs' => $langs,
            'files' => strval(view('files.images-filter-ajax', compact('files'))),
            'pager' => strval($files->render()),
        ]);
    }

    function filterDocs(Request $request) {
        $site = Site::find($request->get('site_id'));
        if ($request->get('lang') == 'arch') {
            $buildQuery = DocTranslate::where('doc_translates.site_id', $request->get('site_id'))
                ->where('doc_translates.ftype', 'doc')
                ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                ->groupBy('docs_sites.id')
                ->whereNotNull('docs_sites.deleted_at');
            if ($request->has('pages') && count($request->get('pages')) > 0 ) {
                $buildQuery->leftJoin('page_doc', 'page_doc.doc_id', '=', 'docs_sites.id')
                    ->leftJoin('pages', 'pages.id', '=', 'page_doc.page_id')
                    ->whereIn('pages.url', $request->get('pages'))
                    ->where('pages.enabled', '=', 1);
            }
        } else {
            $buildQuery = DocTranslate::where('doc_translates.site_id', $request->get('site_id'))
                ->where('doc_translates.language_id', $request->get('lang'))
                ->where('doc_translates.ftype', 'doc')
                ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                ->whereNull('docs_sites.deleted_at');
            if ($request->has('pages') && count($request->get('pages')) > 0 ) {
                $buildQuery->leftJoin('page_doc', 'page_doc.doc_id', '=', 'docs_sites.id')
                    ->leftJoin('pages', 'pages.id', '=', 'page_doc.page_id')
                    ->whereIn('pages.url', $request->get('pages'))
                    ->where('pages.enabled', '=', 1);
            }
        }
        $buildQuery->select('doc_translates.id as id',  'docs_sites.full_url as original_url',
            'doc_translates.full_url as trans_url', 'doc_translates.doc_id as doc_id', 'docs_sites.deleted_at as deleted_at');
        $files = $buildQuery->paginate(20);
        $arch = \DB::table('docs_sites')->whereNotNull('deleted_at')->where('ftype', 'doc')->count();
        $langs = [];
        foreach ($site->languages as $lang) {
            $langs[$lang->id] = [
                'id'   => $lang->id,
                'count_trans' => DocTranslate::where('doc_translates.site_id', $site->id)->where('language_id', $lang->id)
                    ->where('doc_translates.ftype', 'doc')->where('doc_translates.full_url', '!=', '')
                    ->join('docs_sites', 'docs_sites.id', '=', 'doc_translates.doc_id')
                    ->whereNull('docs_sites.deleted_at')
                    ->count(),
                'count_docs' => SiteFile::where('site_id', $site->id)->whereNull('deleted_at')->where('ftype', 'doc')->count(),
            ];
        }
        return \Response::json([
            'arch' => $arch,
            'langs' => $langs,
            'files' => strval(view('files.docs-filter-ajax', compact('files'))),
            'pager' => strval($files->render()),
        ]);
    }
}
