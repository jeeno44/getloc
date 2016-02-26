<?php

Route::group(['middleware' => ['web']], function ()  use ($domain){
    /**
     * Scan routes
     */
    Route::group(['domain' => 'scan.'.$domain], function () {

    });

    Route::group(['domain' => 'partners.'.$domain], function () {
        Route::get('/', ['as' => 'partners.main', 'uses' => 'PartnersController@index']);
        Route::post('/', ['as' => 'partners.register', 'uses' => 'PartnersController@register']);
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

            Route::get('admin/login', ['as' => 'admin.login.form', 'uses' => 'Auth\AuthController@adminForm']);
            Route::post('admin/login', ['as' => 'admin.login.post', 'uses' => 'Auth\AuthController@adminLogin']);
        });

        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);

        Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin'], function () {
            Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);
            Route::get('settings', 'Admin\SettingsController@getSettings');
            Route::post('settings', 'Admin\SettingsController@postSettings');
            Route::get('users/partners', 'Admin\UsersController@partners');
            Route::resource('users', 'Admin\UsersController');
            Route::get('feedback/call', 'Admin\FeedbackController@call');
            Route::get('feedback/demo', 'Admin\FeedbackController@demo');
            Route::delete('feedback/{id}', 'Admin\FeedbackController@destroy');
        });

    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {

});