<?php

namespace App\Http\Controllers;

use App\Language;
use App\Page;
use App\Site;
use App\Translate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function anyTranslate(Request $request)
    {
        extract($request->only(['secret', 'uri', 'lang']));
        if (empty($secret)) {
            return \Response::json(['errors' => ['Secret key required']]);
        }
        if (empty($uri)) {
            return \Response::json(['errors' => ['Uri required']]);
        }
        if (empty($lang)) {
            return \Response::json(['errors' => ['Lang required']]);
        }
        $site = Site::where('secret', $secret)->first();
        if (empty($site)) {
            return \Response::json(['errors' => ['Auth failed. Invalid Secret key']]);
        } else {
            $uri = prepareUri($uri);
            $page = Page::where('url', $uri)->first();
            if (empty($page)) {
                return \Response::json(['errors' => ['Page does not exists']]);
            } else {
                $lang = Language::where('short', $lang)->first();
                if (empty($lang)) {
                    return \Response::json(['errors' => ['Language is invalid']]);
                } else {
                    $response = \Cache::rememberForever($secret.'_'.$page->id.'_'.$lang->id, function() use ($lang, $site, $page) {
                        $response = [];
                        $response['errors'] = [];
                        if ($lang->id == $site->language_id) {
                            $response['results'] = $page->blocks()->lists('text', 'text')->toArray();
                        } else {
                            foreach ($page->blocks as $block)
                            {
                                $trans = $block->translate($lang->id)->first();
                                if (!empty($trans)) {
                                    $response['results'][$block->text] = $block->translate($lang->id)->first()->text;
                                } else {
                                    $response['results'][$block->text] = $block->text;
                                }

                            }
                        }
                        $response['available_languages'] = $site->languages()->lists('name', 'short')->toArray();
                        $response['available_languages'][$site->language->short] = $site->language->name;
                        return $response;
                    });
                    return \Response::json($response);
                }

            }
        }
    }

    public function anyChangeText($id, Request $request)
    {
        $trans = Translate::find($id);
        $trans->update($request->all());
        $page = Page::find($request->get('page'));
        \Cache::forget($page->site->secret.'_'.$page->id.'_'.$trans->language_id);
    }
}
