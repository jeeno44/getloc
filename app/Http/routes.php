<?php

$domain = env('APP_DOMAIN', 'get-loc.ru');

Route::group(['middleware' => ['web']], function ()  use ($domain){
    /**
     * Scan routes
     */
    Route::group(['domain' => 'scan.'.$domain], function () {
        Route::get('/', ['as' => 'scan.main', 'uses' => 'ScanController@index']);
        Route::get('/site/{id}', ['as' => 'scan.site', 'uses' => 'ScanController@site']);
        Route::get('/page/{id}', ['as' => 'scan.page', 'uses' => 'ScanController@page']);
        Route::post('/site', ['as' => 'scan.site.post', 'uses' => 'ScanController@postSite']);
        Route::any('/sites', ['as' => 'scan.sites', 'uses' => 'ScanController@anySites']);
    });

    /**
     * Base site routes
     */
    Route::group(['domain' => $domain], function () {
        Route::get('/', ['as' => 'main', 'uses' => 'HomeController@index']);
        Route::get('/feature', ['as' => 'main.feature', 'uses' => 'HomeController@feature']);
        Route::any('/call-me', ['as' => 'main.call-me', 'uses' => 'HomeController@callMe']);
        Route::any('/get-demo', ['as' => 'main.get-demo', 'uses' => 'HomeController@getDemo']);
        Route::auth();

        Route::get('test', function(){
            set_time_limit(0);
            $phrases = Lang::get('phrases');
            $clientID     = "blackgremlin2";
            $clientSecret = "SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=";
            $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
            $scopeUrl     = "http://api.microsofttranslator.com";
            $grantType    = "client_credentials";
            $authObj      = new \Blackgremlin\Microsofttranslator\AccessTokenAuthentication();
            $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
            $authHeader = "Authorization: Bearer ". $accessToken;
            $translatorObj = new \Blackgremlin\Microsofttranslator\HTTPTranslator();
            foreach ($phrases as $key => $value) {
                $inputStr = $value;
                $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=ru&to=zh-CHS";
                $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
                $xmlObj = simplexml_load_string($strResponse);
                $phrases[$key] = strval($xmlObj[0]);
            }
            dd($phrases);
        });
    });


});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {
    Route::any('/add-site', ['as' => 'api.add-site', 'uses' => 'ApiController@createSite']);
});