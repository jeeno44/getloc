<?php

Route::group(['middleware' => ['web']], function ()  use ($domain){
    /**
     * Scan routes
     */
    Route::group(['domain' => 'scan.'.$domain], function () {

    });

    /**
     * Base site routes
     */
    Route::group(['domain' => $domain], function () {
        //Route::auth();
        Route::group(['middleware' => ['guest'], 'name' => 'auth'], function () {
            Route::get('/google/redirect', ['as' => 'google.redirect', 'uses' => 'Auth\SocialController@linkToGoogle']);
            Route::any('/google/callback', ['as' => 'google.callback', 'uses' => 'Auth\SocialController@googleCallback']);
            Route::get('/twitter/redirect', ['as' => 'twitter.redirect', 'uses' => 'Auth\SocialController@linkToTwitter']);
            Route::any('/twitter/callback', ['as' => 'twitter.callback', 'uses' => 'Auth\SocialController@twitterCallback']);
            Route::get('/facebook/redirect', ['as' => 'google.redirect', 'uses' => 'Auth\SocialController@linkToFacebook']);
            Route::any('/facebook/callback', ['as' => 'google.callback', 'uses' => 'Auth\SocialController@facebookCallback']);
        });
    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {

});
