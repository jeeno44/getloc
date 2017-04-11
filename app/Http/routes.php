<?php

$domain = env('APP_DOMAIN', 'getloc.dev');

Route::group(['middleware' => ['web']], function ()  use ($domain){
    /**
     * Scan routes
     */
    Route::group(['domain' => 'scan.'.$domain, 'middleware' => 'scan'], function () {
        Route::get('/', ['as' => 'scan.main', 'uses' => 'ScanController@index']);
        Route::get('/site/{id}', ['as' => 'scan.site', 'uses' => 'ScanController@site']);
        Route::get('/page/{id}', ['as' => 'scan.page', 'uses' => 'ScanController@page']);
        Route::post('/site', ['as' => 'scan.site.post', 'uses' => 'ScanController@postSite']);
        Route::any('/sites', ['as' => 'scan.sites', 'uses' => 'ScanController@anySites']);
        Route::get('login', ['as' => 'scan.login.form', 'uses' => 'Auth\AuthController@showLoginForm']);
        Route::get('activated', ['as' => 'scan.activated', 'uses' => 'Auth\AuthController@activate']);
//        Route::post('login', ['as' => 'scan.login.post', 'uses' => 'Auth\AuthController@login']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
        Route::get('register', ['as' => 'scan.register.form', 'uses' => 'Auth\AuthController@showRegistrationForm']);
        Route::get('registered', ['as' => 'scan.registered', 'uses' => 'Auth\AuthController@registered']);
        Route::post('register', ['as' => 'scan.register.post', 'uses' => 'Auth\AuthController@register']);
        Route::any('/get-demo', ['as' => 'scan.get-demo', 'uses' => 'ScanController@getDemo']);
        Route::get('contragent', 'ScanController@contragent');
        Route::post('/details-form', ['as' => 'scan.billing.details-store', 'uses' => 'ScanController@detailsStore']);
        Route::get('/export/{id}/{pageID?}', 'ScanController@export');
        Route::get('/xliff/{id}/{pageID?}', 'ScanController@xliff');

        Route::post('/tmxexport/{id}/{pageID?}', ['as' => 'scan.tmxexport', 'uses' => 'ScanController@tmxexport']);
        Route::post('/xlfexport/{id}/{pageID?}', ['as' => 'scan.xlfexport', 'uses' => 'ScanController@xlfexport']);
        Route::post('/smartcat/{id}', ['as' => 'smartcat.export', 'uses' => 'SmartCatController@exportSite']);

        Route::group(['middleware' => ['admin']], function () {
            Route::resource('users', 'ScanUsersController');
        });
        Route::get('/profile', ['as' => 'scan.account.personal', 'uses' => 'ScanPersonalController@index']);
        Route::post('/profile', ['as' => 'scan.account.personal-store', 'uses' => 'ScanPersonalController@store']);
        Route::get('/delete/{id}', 'ScanController@delete');
    });

    /**
     * Base site routes
     */
    Route::group(['domain' => $domain], function () {
        Route::get('/xliff/{id}/{pageID?}', 'ScanController@xliff');
        Route::get('/', ['as' => 'main', 'uses' => 'HomeController@index']);
        Route::get('/feature', ['as' => 'main.feature', 'uses' => 'HomeController@feature']);
        Route::any('/call-me', ['as' => 'main.call-me', 'uses' => 'HomeController@callMe']);
        Route::any('/get-demo', ['as' => 'main.get-demo', 'uses' => 'HomeController@getDemo']);
        Route::any('/add-site-unreg', ['as' => 'main.add-site-unreg', 'uses' => 'HomeController@addSiteUnregistered']);
        Route::any('/send-feedback', ['as' => 'main.send-feedback', 'uses' => 'HomeController@sendFeedback']);
        Route::post('/xlfexport/{id}/{pageID?}', ['as' => 'main.xlfexport', 'uses' => 'ScanController@xlfexport']);
        // Account
        Route::group(['middleware' => 'auth', 'prefix' => 'account'], function() {
            Route::get('/', ['as' => 'main.account', 'uses' => 'AccountController@projectOverview']);
            Route::get('/overview', ['as' => 'main.account.overview', 'uses' => 'AccountController@projectOverview']);
            Route::get('/languages', ['as' => 'main.account.languages', 'uses' => 'AccountController@projectLanguages']);
            Route::get('/projects', ['as' => 'main.account.selectProject', 'uses' => 'AccountController@selectProject']);
            Route::get('/setProjects/{id}', ['as' => 'main.account.setProject', 'uses' => 'AccountController@setProject']);

            Route::post('/switchingLanguage', ['as' => 'main.account.switchLang', 'uses' => 'AccountController@turnLang']);
            #Route::get('/addLanguage/', ['as' => 'main.account.addlang', 'uses' => 'AccountController@addLanguage']);
            #Route::post('/addLanguage/', ['as' => 'main.account.postaddlang', 'uses' => 'AccountController@postAddLanguage']);


            Route::get('/widget/', ['as' => 'main.account.widget', 'uses' => 'AccountController@widget']);
            Route::get('/code', ['as' => 'main.account.settings', 'uses' => 'AccountController@settings']);
            //Route::get('/addProject/', ['as' => 'main.account.addproject', 'uses' => 'AccountController@addProject']);

            Route::get('/phrase/not_translated', ['as' => 'main.account.phrase1', 'uses' => 'AccountController@phraseNotTranslatesTab']);
            Route::get('/phrase/translated', ['as' => 'main.account.phrase2', 'uses' => 'AccountController@phraseTranslatesTab']);
            Route::get('/phrase/published', ['as' => 'main.account.phrase3', 'uses' => 'AccountController@phrasePublishingTab']);
            Route::get('/phrase/', ['as' => 'main.account.phrase', 'uses' => 'AccountController@phraseNotTranslatesTab']);
            Route::get('/clear-filter/', ['as' => 'main.account.clear-filter', 'uses' => 'AccountController@clearFilter']);

            Route::get('/add-project/', ['as' => 'main.account.add-project', 'uses' => 'ProjectController@addProject']);
            Route::post('/add-project/', ['as' => 'main.account.post-add-project', 'uses' => 'ProjectController@postAddProject']);
            Route::get('/add_language/', ['as' => 'main.account.addlanguages', 'uses' => 'ProjectController@languages']);
            Route::post('/languages/{id}', ['as' => 'main.account.post-languages', 'uses' => 'ProjectController@postLanguages']);

            Route::post('/phrase/setFilter', ['as' => 'main.account.setFilter', 'uses' => 'AccountController@setFilterPharse']);

            Route::get('/widget/', ['as' => 'main.account.widget', 'uses' => 'AccountController@widget']);
            Route::post('/widget/', ['as' => 'main.account.widgetPost', 'uses' => 'AccountController@widgetPost']);

            /* ajax */
            Route::post('/robot/{id}', ['as' => 'api.robot', 'uses' => 'ApiController@anyBing']);
            Route::post('/getTextFromRobot/{id}', ['as' => 'api.robot', 'uses' => 'ApiController@maybeTranslateFromBing']);
            Route::post('/saveTranslate/', ['as' => 'main.account.handTranslate', 'uses' => 'AccountController@saveTranslate']);
            Route::post('/setTypeView/', ['as' => 'main.account.setTypeView', 'uses' => 'AccountController@setTypeView']);
            Route::post('/setStatusBlock/', ['as' => 'main.account.setStatusBlock', 'uses' => 'AccountController@turnStatusPublishing']);
            Route::post('/markHandTranslate/{id}', ['as' => 'main.account.markHandTranslate', 'uses' => 'AccountController@markHandTranslate']);
            Route::post('/setAutoPublishing', ['as' => 'main.account.autoPub', 'uses' => 'AccountController@setAutoPublishing']);
            Route::post('/setAutoTranslate', ['as' => 'main.account.autoTrans', 'uses' => 'AccountController@setAutoTranslate']);
            Route::post('/ajaxPhraseRender', ['as' => 'main.account.ajaxphrase', 'uses' => 'AccountController@phraseAjaxRender']);
            Route::post('/archive-block', ['as' => 'main.account.archive-block', 'uses' => 'AccountController@setToArchive']);


//            Route::post('/ajaxRenderingBlocksPages', ['as' => 'main.account.ajaxRenderingBlocksPages', 'uses' => 'AccountController@ajaxRenderingBlocksPages']);
//            Route::any('/ajaxRenderingBlocksPages', ['as' => 'main.account.ajaxRenderingBlocksPages', 'uses' => 'AccountController@ajaxRenderingBlocksPages']);
            Route::post('/ajaxRenderingTitlePages', ['as' => 'main.account.ajaxRenderingTitlePages', 'uses' => 'AccountController@ajaxRenderingTitlePages']);
            Route::post('/disableDisplayPhrase', ['as' => 'main.account.disableDisplayPhrase', 'uses' => 'AccountController@disableDisplayPhrase']);
            Route::post('/pagesDisable', ['as' => 'main.account.pagesDisable', 'uses' => 'AccountController@setPagesDisable']);
            Route::post('/locationPhrase', ['as' => 'main.account.locationPhrase', 'uses' => 'AccountController@setPagesSession']);
            Route::post('/orderingTranslation', ['as' => 'main.account.orderingTranslation', 'uses' => 'AccountController@setOrderingTranslation']);

            Route::get('/pages', ['as' => 'main.account.pages', 'uses' => 'AccountController@pagesView']);

            Route::post('/setArchive', ['as' => 'main.account.setArchive', 'uses' => 'AccountController@setArchiveTranslate']);

            Route::get('/get-history/{id}', ['as' => 'main.account.get-history', 'uses' => 'AccountController@getHistory']);
            Route::get('/pages/disable/{id}', 'AccountController@disablePage');
            Route::get('/pages/enable/{id}', 'AccountController@enablePage');
            Route::get('/language/delete/{siteID}/{languageID}', ['as' => 'main.lang.del', 'uses' => 'ProjectController@deleteLanguages']);
            Route::get('/images', ['as' => 'main.account.images', 'uses' => 'FilesController@images']);
            Route::get('/docs', ['as' => 'main.account.docs', 'uses' => 'FilesController@docs']);
            Route::post('/filter/images', ['as' => 'main.account.filter.images', 'uses' => 'FilesController@filterImages']);
            Route::post('/filter/docs', ['as' => 'main.account.filter.docs', 'uses' => 'FilesController@filterDocs']);
            Route::post('/filter/archive/{id}', ['as' => 'main.account.filter.archive', 'uses' => 'FilesController@archive']);
            Route::post('/filter/save/{id}', ['as' => 'main.account.filter.archive', 'uses' => 'FilesController@save']);
            Route::post('/filter/upload/{id}', ['as' => 'main.account.filter.archive', 'uses' => 'FilesController@upload']);

            Route::any('/pages/autocomplete/{id}', 'AccountController@pagesAutoComplete');

            Route::get('/personal', ['as' => 'main.account.personal', 'uses' => 'PersonalController@index']);
            Route::post('/personal', ['as' => 'main.account.personal-store', 'uses' => 'PersonalController@store']);
            Route::get('/collect', ['as' => 'main.account.collect', 'uses' => 'ProjectController@collect']);
            Route::get('/collect/{id}', ['as' => 'main.account.collect_page', 'uses' => 'ProjectController@collectPage']);
            Route::get('/build', ['as' => 'main.account.build', 'uses' => 'ProjectController@build']);
            Route::post('/build', ['as' => 'main.account.build', 'uses' => 'ProjectController@buildStore']);
            Route::get('import', 'ProjectController@import');
            Route::post('import', 'ProjectController@storeImport');
            Route::get('/payment', ['as' => 'main.account.payment', 'uses' => 'AccountController@accountPayment']);
            Route::get('/history-collect', 'ProjectController@historyCollect');
        });
        Route::group(['middleware' => 'auth'], function() {
            Route::get('/xml/read/{id}', 'XmlController@read');
        });
        Route::get('qauth/{id}', function ($id){
            $user = \App\User::find($id);
            \Auth::login($user);
            return redirect('/account');
        });

    });

});

/**
 * Api routes
 */
Route::group(['domain' => 'api.'.$domain], function () {
    Route::any('/add-site', ['as' => 'api.add-site', 'uses' => 'ApiController@createSite']);
    Route::any('/add-unreg-site', ['as' => 'api.add-unreg-site', 'uses' => 'ApiController@createUnregSite']);
    Route::any('/translate', ['as' => 'api.translate', 'uses' => 'ApiController@anyTranslate']);
});

require_once 'andy_routes.php';

Route::get('fix-me', 'BugFixesController@fixMe');

Route::get('stat', function (){
    $records = \DB::table('site_state')->join('sites', 'sites.id', '=', 'site_state.site_id')
        ->select('sites.url', 'site_state.created_at', 'site_state.status')
        ->orderBy('site_state.id', 'desc')
        ->get();
    echo "<table>";
    echo "<tr><th>Дата и время</th><th>Сайт</th><th>Статус</th></tr>";
    foreach ($records as $record) {
        echo "<tr><td>{{$record->created_at}}</td><td>{{$record->url}}</td><td>{{$record->status}}</td></tr>";
    }
    echo "</table>";
});

