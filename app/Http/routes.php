<?php

Route::get('/', 'IndexController@getIndex');
Route::post('/', 'IndexController@postIndex');
Route::get('/site/{id}', 'IndexController@getSite');
Route::get('/page/{id}', 'IndexController@getPage');

Route::get('test', function(){
    dd(getPageContent('http://devlock.ru/'));
});