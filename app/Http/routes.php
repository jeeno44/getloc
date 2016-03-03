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
        Route::group(['middleware' => 'auth', 'prefix' => 'account'], function() {
            Route::get('/', ['as' => 'main.account', 'uses' => 'AccountController@projectOverview']);
            Route::get('/overview', ['as' => 'main.account.overview', 'uses' => 'AccountController@projectOverview']);
            //Route::get('/languages', ['as' => 'main.account.languages', 'uses' => 'AccountController@projectLanguages']);
            Route::get('/projects', ['as' => 'main.account.selectProject', 'uses' => 'AccountController@selectProject']);
            Route::get('/setProjects/{id}', ['as' => 'main.account.setProject', 'uses' => 'AccountController@setProject']);
            Route::post('/switchingLanguage', ['as' => 'main.account.switchLang', 'uses' => 'AccountController@turnLang']);
            Route::get('/addLanguage/', ['as' => 'main.account.addlang', 'uses' => 'AccountController@addLanguage']);
            Route::post('/addLanguage/', ['as' => 'main.account.postaddlang', 'uses' => 'AccountController@postAddLanguage']);
            //Route::get('/addProject/', ['as' => 'main.account.addproject', 'uses' => 'AccountController@addProject']);
            Route::get('/phrase/', ['as' => 'main.account.phrase', 'uses' => 'AccountController@phrase']);
            Route::get('/add-project/', ['as' => 'main.account.add-project', 'uses' => 'ProjectController@addProject']);
            Route::post('/add-project/', ['as' => 'main.account.post-add-project', 'uses' => 'ProjectController@postAddProject']);
            Route::get('/languages/', ['as' => 'main.account.languages', 'uses' => 'ProjectController@languages']);
            Route::post('/languages/{id}', ['as' => 'main.account.post-languages', 'uses' => 'ProjectController@postLanguages']);
        });
        
    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {
    Route::any('/add-site', ['as' => 'api.add-site', 'uses' => 'ApiController@createSite']);
});

require_once 'andy_routes.php';