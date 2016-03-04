<?php

Route::group(['prefix' => 'yandex-kassa'], function(){
    Route::get('show-form/{orderId}/{customerId}/{sum}', ['as' => 'yandex-kassa.form', 'uses' => 'Blackgremlin\Yandexkassa\YandexKassaController@showForm']);
    Route::any('check', 'Blackgremlin\Yandexkassa\YandexKassaController@check');
    Route::any('aviso', 'Blackgremlin\Yandexkassa\YandexKassaController@aviso');
    Route::get('success', function() {
        return redirect()->route('main.billing.success');
    });
    Route::get('fail', function() {
        return redirect()->route('main.billing.fail');
    });
});