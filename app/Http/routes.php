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
        
        // Account
        Route::get('/account', ['as' => 'main.account', 'uses' => 'AccountController@projectOverview']);
        Route::get('/account/overview', ['as' => 'main.account.overview', 'uses' => 'AccountController@projectOverview']);
        Route::get('/account/languages', ['as' => 'main.account.languages', 'uses' => 'AccountController@projectLanguages']);
        Route::get('/account/projects', ['as' => 'main.account.selectProject', 'uses' => 'AccountController@selectProject']);
        Route::get('/account/setProjects/{id}', ['as' => 'main.account.setProject', 'uses' => 'AccountController@setProject']);
        Route::post('/account/switchingLanguage', ['as' => 'main.account.switchLang', 'uses' => 'AccountController@turnLang']);
        Route::get('/account/addLanguage/', ['as' => 'main.account.addlang', 'uses' => 'AccountController@addLanguage']);
        Route::post('/account/addLanguage/', ['as' => 'main.account.postaddlang', 'uses' => 'AccountController@postAddLanguage']);
        Route::get('/account/addProject/', ['as' => 'main.account.addproject', 'uses' => 'AccountController@addProject']);
        Route::get('/account/phrase/', ['as' => 'main.account.phrase', 'uses' => 'AccountController@phrase']);
    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {
    Route::any('/add-site', ['as' => 'api.add-site', 'uses' => 'ApiController@createSite']);
});

require_once 'andy_routes.php';