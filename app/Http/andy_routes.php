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
        Route::auth();
    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {

});
