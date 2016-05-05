<?php

namespace App\Http\Controllers;

use App\Block;
use App\Coupon;
use App\Language;
use App\Page;
use App\Site;
use App\SiteSettings;
use App\SocialAccount;
use App\Translate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    
    /**
     * 
     * @TODO: cache...
     * 
     * @param Request $request
     * @return type
     */
    
    public function anyTranslate(Request $request)
    {
        extract($request->only(['secret', 'uri', 'lang', 'callback']));
        $response = [];
        if (empty($secret)) {
            $response['error'] = ['msg' => 'Secret key required', 'code' => 1];
            return $this->makeResponse($response, $callback);
        }
        if (empty($uri)) {
            $response['error'] = ['msg' => 'Uri required', 'code' => 2];
            return $this->makeResponse($response, $callback);
        }
        if (empty($lang)) {
            $response['error'] = ['msg' => 'Lang required', 'code' => 3];
            return $this->makeResponse($response, $callback);
        }
        $site = Site::where('secret', $secret)->first();
        if (empty($site)) {
            $response['error'] = ['msg' => 'Auth failed. Invalid Secret key', 'code' => 4];
            return $this->makeResponse($response, $callback);
        } else {
            $subscription = \App\Subscription::where('site_id', $site->id)->first();
            if (!$subscription || $subscription->deposit <= 0.00 || !$subscription->last_id) {
                $response['error'] = ['msg' => 'This project is not active subscription', 'code' => 8];
                return $this->makeResponse($response, $callback);
            }
            $uri = prepareUri($uri);
            $page = Page::where('url', $uri)->first();
            if (!$page) {
                Page::create([
                    'url'           => $uri,
                    'site_id'       => $site->id,
                    'code'          => 200,
                    'visited'       => 1,
                ]);
                //$this->dispatch(new \App\Jobs\Spider($site));
                \Redis::publish('collector-new-page', json_encode(['site' => $site->id, 'api' => 'api.'.env('APP_DOMAIN').'/python/new-page/'.$site->id, 'url' => $uri], JSON_UNESCAPED_UNICODE));
                //\Event::fire('maps.done', $site);
                $response['error'] = ['msg' => 'Page does not exists', 'code' => 5];
                return $this->makeResponse($response, $callback);
            } else {
                $lang = Language::where('short', $lang)->first();
                if (empty($lang)) {
                    $response['error'] = ['msg' => 'Language is invalid', 'code' => 6];
                    return $this->makeResponse($response, $callback);
                } else {
                    \Cache::forget($secret.'_'.$page->id.'_'.$lang->id);//TODO переделать кеширование для новых условий
                    $response = \Cache::rememberForever($secret.'_'.$page->id.'_'.$lang->id, function() use ($lang, $site, $page, $subscription) {
                        if ($lang->id == $site->language_id) {
                            $response['results'] = $page->blocks()->lists('text', 'text')->toArray();
                        } else {
                            $blocks = $page->blocks()->join('translates', 'blocks.id', '=', 'translates.block_id')
                                ->where('translates.language_id', $lang->id)
                                ->where('blocks.enabled', 1)
                                ->where('blocks.id', '<=', $subscription->last_id)
                                ->where('translates.enabled', 1)
                                ->select('blocks.text', 'translates.id as tid', 'translates.text as ttext')
                                ->orderBy(\DB::raw('LENGTH(blocks.text)'), 'DESC')
                                ->get();
                            foreach ($blocks as $block)
                            {
                                if (!empty($block->ttext)) {
                                    $response['results'][html_entity_decode($block->text)] = $block->ttext;
                                } else {
                                    $response['results'][html_entity_decode($block->text)] = $block->text;
                                }
                            }
                        }
                        if (empty($response['results'])) {
                            $response['error'] = ['msg' => 'Site is processed', 'code' => 7];
                        }
                        $response['available_languages'] = $site->languages()->where('enabled', 1)->lists('name', 'short')
                            ->take($subscription->count_languages)
                            ->toArray();
                        $response['available_languages'][$site->language->short] = $site->language->name;
                        return $response;
                    });
                }
            }
        }
        if (!empty($callback)) {
            return \Response::make($callback."(".json_encode($response).")");
        } else {
            return \Response::make(json_encode($response));
        }
    }

    function makeResponse($data, $callback = null)
    {
        if (!empty($callback)) {
            return \Response::make($callback."(".json_encode($data).")");
        } else {
            return \Response::make(json_encode($data));
        }
    }

    public function anyChangeText($id, Request $request)
    {
        $trans = Translate::find($id);
        $trans->update($request->all());
        $page = Page::find($request->get('page'));
        \Cache::forget($page->site->secret.'_'.$page->id.'_'.$trans->language_id);
    }
    
    /**
     * @TODO: Нужна чистка кэша, пока хз как это сделать
     * 
     * 
     * @param type $id
     * @return type
     */
    
    public function anyBing($id)
    {
        $trans    = Translate::find($id);
        $langID   = Site::find($trans->block->site_id)->language_id; //TODO сделать нормально, одним запросом, юзая связи 
        $fromLang = Language::find($langID)->short;
        
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
        $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=".$fromLang."&to=".$trans->language->short;
        $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
        $xmlObj = simplexml_load_string($strResponse);
        $text = strval($xmlObj[0]);
        $trans->text = $text;
        $trans->type_translate_id = 1;
        $connect = $trans->save();

        if ($connect) {
            $historyPhrase = new AccountController();
            $historyPhrase->setHistoryPhrase($trans);
        }

        \Event::fire('site.changed', Site::find($trans->block->site_id));
        
        #Todo: нету больше page-id, надо что-то переделать
        #\Cache::forget($page->site->secret.'_'.$page->id.'_'.$trans->language_id);
        return json_encode(array('text' => $text, 'message' => trans('account.successTranslate')));
    }
    
    /**
     * Выводим в текстареа перевод
     * 
     * @param  int $id
     * @return string
     * @access public
     */
    
    public function maybeTranslateFromBing($id)
    {
        $trans    = Translate::find($id);
        $langID   = Site::find($trans->block->site_id)->language_id; //TODO сделать нормально, одним запросом, юзая связи 
        $fromLang = Language::find($langID)->short;
        
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
        $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=".$fromLang."&to=".$trans->language->short;
        $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
        $xmlObj = simplexml_load_string($strResponse);
        $text = strval($xmlObj[0]);
        
        return json_encode(array('text' => $text, 'message' => trans('account.successTranslate')));
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
                'url'           => $url,
                'name'          => $url,
                'user_id'       => $request->get('user_id'),
                'secret'        => str_random(32),
                'language_id'   => $defaultLang->id,
                'demo'          => 1,
            ]);
            $site->save();
            if (!empty($langs)) {
                foreach ($langs as $lang) {
                    if (!empty($lang) && !$site->hasLanguage($lang)) {
                        $site->languages()->attach($lang);
                    }
                }
            }
            \DB::table('sites_settings')->insert([
                'site_id'           => $site->id,
                'auto_publishing'   => $request->has('auto_publishing'),
                'auto_translate'    => $request->has('auto_translate')
            ]);
        }
        \Event::fire('site.start', $site);
        //$this->dispatch(new \App\Jobs\Spider($site));
    }
}
