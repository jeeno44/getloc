<?php

Route::group(['middleware' => 'auth', 'prefix' => 'home'], function(){
    Route::get('/', 'HomeController@index');
    Route::post('/', 'HomeController@postIndex');
    Route::get('/site/{id}', 'HomeController@getSite');
    Route::get('/sites/delete/{id}', 'HomeController@getDeleteSite');
    Route::get('/sites/edit/{id}', 'HomeController@getEditSite');
    Route::post('/sites/edit/{id}', 'HomeController@postEditSite');
    Route::get('/page/{id}', 'HomeController@getPage');
});

Route::group([ 'prefix' => 'home'], function(){
    Route::get('/site/{id}', 'HomeController@getSite');
    Route::get('/sites/delete/{id}', 'HomeController@getDeleteSite');
    Route::get('/page/{id}', 'HomeController@getPage');
});

// Authentication Routes...
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Password Reset Routes...
Route::controller('password', 'Auth\PasswordController');
Route::get('/', 'IndexController@getIndex');

Route::controller('api', 'ApiController');


