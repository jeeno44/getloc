<?php

namespace App\Http\Controllers;

use App\Language;
use App\Site;
use App\Translate;
use Illuminate\Http\Request;

class XmlController extends Controller
{
    public function read($siteID, Request $request)
    {
        $targetLang = null;
        $site = Site::find($siteID);
        if (!$site) {
            throw new \Exception('Invalid argument');
        }
        $xml = simplexml_load_file(public_path('tmp/xliff.xml'));
        foreach($xml->file->attributes() as $key => $val) {
            if ($key == 'target-language') {
                $arr = explode('-', $val);
                if (!empty($arr[0])) {
                    $tl = $arr[0];
                    $lang = Language::where('short', $tl)->first();
                    if ($lang) {
                        $targetLang = $lang;
                    }
                }
            }
        }
        if (!$targetLang || !$site->hasLanguage($targetLang->id)) {
            throw new \Exception('Invalid target language');
        }
        $blocks = [];
        $blockIds = [];
         foreach ($xml->file->body as $unit) {
            foreach($unit as $key => $val) {
                foreach($val->attributes() as $a => $b) {
                    if ($a == 'id') {
                        $blocks[(int) $b] = (String) $val->target;
                        $blockIds[] = (int) $b;
                    }
                }
            }
        }
        $errors = 0;
        $translates = Translate::whereIn('block_id', $blockIds)->where('language_id', $targetLang->id)->get();
        $diff = count($blocks) - count($translates);
        foreach ($translates as $trans) {
            if (!empty($blocks[$trans->block_id])) {
                $trans->update(['text' => $blocks[$trans->block_id]]);
            } else {
                $errors ++;
            }
        }
        $response = [
            'total'     => count($blocks),
            'success'   => count($blocks) - $errors - $diff,
            'fails'     => $errors + $diff,
        ];
        return \Response::json($response);
    }
}
