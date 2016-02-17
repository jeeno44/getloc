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
        Route::group(['middleware' => ['guest'], 'name' => 'auth'], function () {
            Route::get('/google/redirect', ['as' => 'google.redirect', 'uses' => 'Auth\SocialController@linkToGoogle']);
            Route::any('/google/callback', ['as' => 'google.callback', 'uses' => 'Auth\SocialController@googleCallback']);
            Route::get('/twitter/redirect', ['as' => 'twitter.redirect', 'uses' => 'Auth\SocialController@linkToTwitter']);
            Route::any('/twitter/callback', ['as' => 'twitter.callback', 'uses' => 'Auth\SocialController@twitterCallback']);
            Route::get('/facebook/redirect', ['as' => 'facebook.redirect', 'uses' => 'Auth\SocialController@linkToFacebook']);
            Route::any('/facebook/callback', ['as' => 'facebook.callback', 'uses' => 'Auth\SocialController@facebookCallback']);
            Route::get('/social/email', ['as' => 'social.email', 'uses' => 'Auth\SocialController@getEmail']);
            Route::post('/social/email', ['as' => 'social.email.save', 'uses' => 'Auth\SocialController@postEmail']);

            Route::get('login', ['as' => 'login.form', 'uses' => 'Auth\AuthController@showLoginForm']);
            Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\AuthController@login']);

            Route::get('register', ['as' => 'register.form', 'uses' => 'Auth\AuthController@showRegistrationForm']);
            Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\AuthController@register']);

            Route::get('password/reset/{token?}', ['as' => 'password.reset.form', 'uses' => 'Auth\PasswordController@showResetForm']);
            Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
            Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@reset']);
        });
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {

});
