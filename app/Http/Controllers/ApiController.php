<?php

namespace App\Http\Controllers;

use App\Block;
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
        extract($request->only(['secret', 'uri', 'lang', 'callback']));
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
                            $blocks = $page->blocks()->join('translates', 'blocks.id', '=', 'translates.block_id')
                                ->where('translates.language_id', $lang->id)
                                ->select('blocks.text', 'translates.id as tid', 'translates.text as ttext')
                                ->get();
                            foreach ($blocks as $block)
                            {
                                if (!empty($block->ttext)) {
                                    $response['results'][$block->text] = $block->ttext;
                                } else {
                                    $response['results'][$block->text] = $block->text;
                                }
                            }
                        }
                        $response['available_languages'] = $site->languages()->lists('name', 'short')->toArray();
                        $response['available_languages'][$site->language->short] = $site->language->name;
                        return $response;
                    });
                    if (!empty($callback)) {
                        return \Response::make($callback."(".json_encode($response).")");
                    } else {
                        return \Response::make(json_encode($response));
                    }
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

    public function anyBing($id, Request $request)
    {
        $trans = Translate::find($id);
        $page = Page::find($request->get('page'));
        $clientID     = "blackgremlin2";
        $clientSecret = "SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=";
        $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
        $scopeUrl     = "http://api.microsofttranslator.com";
        $grantType    = "client_credentials";
        $authObj      = new \Blackgremlin\Microsofttranslator\AccessTokenAuthentication();
        $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
        $authHeader = "Authorization: Bearer ". $accessToken;
        $translatorObj = new \Blackgremlin\Microsofttranslator\HTTPTranslator();
        $inputStr = $trans->block->text;
        $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=ru&to=".$trans->language->short;
        $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
        $xmlObj = simplexml_load_string($strResponse);
        $text = strval($xmlObj[0]);
        $trans->text = $text;
        $trans->save();
        \Cache::forget($page->site->secret.'_'.$page->id.'_'.$trans->language_id);
        return $text;
    }

    public function anyBingTranslate($id, Request $request)
    {
        $trans = Translate::find($id);
        $clientID     = "blackgremlin2";
        $clientSecret = "SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=";
        $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
        $scopeUrl     = "http://api.microsofttranslator.com";
        $grantType    = "client_credentials";
        $authObj      = new \Blackgremlin\Microsofttranslator\AccessTokenAuthentication();
        $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
        $authHeader = "Authorization: Bearer ". $accessToken;
        $translatorObj = new \Blackgremlin\Microsofttranslator\HTTPTranslator();
        $inputStr = $trans->block->text;
        $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=ru&to=".$trans->language->short;
        $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
        $xmlObj = simplexml_load_string($strResponse);
        return \Response::json([
            $trans->block->text => strval($xmlObj[0])
        ]);
    }

    public function createSite(Request $request)
    {
        $url = $request->get('url');
        $langs = $request->get('languages');
        $url = prepareUri($url);
        $site = Site::where('url', $url)->first();
        if (empty($site)) {
            $defaultLang = Language::where('short', 'ru')->first();
            $site = new Site([
                'url'   => $url,
                'name'  => $url,
                'user_id'   => $request->get('user_id'),
                'secret'    => str_random(32),
                'language_id'   => $defaultLang->id,
            ]);
            $site->save();
            Page::create([
                'url'       => $url,
                'site_id'   => $site->id,
                'code'      => 200,
            ]);
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    if (!empty($lang) && !$site->hasLanguage($lang)) {
                        $site->languages()->attach($lang);
                    }
                }
            }
        }
        $this->dispatch(new \App\Jobs\Spider($site));
    }

}
