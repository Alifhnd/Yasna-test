<?php

Route::group(
     [
          'middleware' => ['web', 'auth', 'is:admin'],
          'prefix'     => 'manage',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/', 'ManageController@index');
         Route::get('/dashboard', 'ManageController@index');
         Route::get('/master/search', 'ManageController@masterSearch')->name('master-search');
         Route::get('/graphs-demo', 'ManageController@graphDemo');
         Route::get('/elements-demo', 'ManageController@elementsDemo');
         //Route::get('/alerts-refresh', 'ManageController@refreshAlerts'); // DEPRECATED
         Route::get('/widget-refresh/{key}', 'WidgetsController@refreshWidget');
         Route::get('widget/refresh-col', 'WidgetsController@refreshColumn');
         Route::get('widget/refresh-widget-setting', 'WidgetsController@refreshWidgetSetting');
         Route::get('/widget-repository', 'WidgetsController@widgetRepository');

         /*-----------------------------------------------
         | Account Settings ...
         */
         Route::group(['prefix' => "account"], function () {
             Route::get('/{request_tab?}', 'AccountController@index');
             Route::get('/act/{action}', 'AccountController@action');


             Route::group(['prefix' => 'save'], function () {
                 Route::post('/password', 'AccountController@savePassword');
                 Route::post('/personal', 'AccountController@savePersonal');
                 Route::get('/theme/{theme_name}', 'AccountController@saveTheme');
                 Route::get('/widgets/{sort_order}', 'WidgetsController@saveWidgetsOrder');
                 Route::post('/widgets-add', 'WidgetsController@addWidget')->name('dashboard-widget-add');
                 Route::get('/widgets-remove/{key}', 'WidgetsController@removeWidget');
             });
         });
     }
);


/*
|--------------------------------------------------------------------------
| Downstream Settings
|--------------------------------------------------------------------------
|
*/
Route::group(
     [
          'middleware' => ['web', 'auth', 'is:super'],
          'prefix'     => 'manage/downstream',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/setting/{action}/{hashid?}', 'SettingsDownstreamController@action')
              ->name("downstream-setting-action")
         ;

         Route::get('/{request_tab?}/{option?}', 'DownstreamController@index');

         Route::group(['prefix' => 'save'], function () {
             Route::post('/setting', 'SettingsDownstreamController@save');
         });
     }
);


/*
|--------------------------------------------------------------------------
| Upstream Settings
|--------------------------------------------------------------------------
|
*/
Route::group(
     [
          'middleware' => ['web', 'auth', 'is:super'],
          'prefix'     => 'manage/upstream',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/setting/{action}/{hash_id?}', 'UpstreamController@settingAction');
         Route::get('/state/{action}/{hash_id?}', 'UpstreamController@stateAction');
         Route::get('/domain/{action}/{hash_id?}', 'UpstreamController@domainAction');

         Route::get('/{request_tab?}/{option?}', 'UpstreamController@index');


         Route::group(['prefix' => 'save'], function () {
             Route::post('/setting', 'UpstreamSettingsController@save');
             Route::post('/setting-set', 'UpstreamSettingsController@set');
             Route::post('/setting-activeness', 'UpstreamSettingsController@saveActiveness');

             Route::post('/state', 'UpstreamController@stateSave');
             Route::post('/state-activeness', 'UpstreamController@stateActiveness');
             Route::post('/state-city', 'UpstreamController@stateCitySave');

             Route::post('/domain', 'UpstreamController@domainSave');
             Route::post('/domain-activeness', 'UpstreamController@domainActiveness');
         });
     }
);


/*
|--------------------------------------------------------------------------
| Statue
|--------------------------------------------------------------------------
|
*/
Route::group(
     [
          'middleware' => ['web', 'auth'],
          'prefix'     => 'manage/statue',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/', 'StatueController@index');
         Route::get('init', 'StatueController@init');
         Route::get('op-cache', 'StatueController@opCacheReset');
         Route::get('activeness/{hashid}', 'StatueController@activeness');

         Route::group(['prefix' => 'save'], function () {
             Route::post('/activeness', 'StatueController@saveActiveness')->name('statue-activeness');
         });
     }
);


/*
|--------------------------------------------------------------------------
| Weather widget
|--------------------------------------------------------------------------
|
*/
Route::group(
     [
          'middleware' => ['web', 'auth'],
          'prefix'     => 'manage',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/weather/choose_state', 'WeatherController@chooseStateModal');
         Route::post('/weather/update_state', 'WeatherController@updateState');
     }
);

/*
*-------------------------------------------------------
* Notifications
*-------------------------------------------------------
*/
Route::group(
     [
          'middleware' => ['web', 'auth'],
          'prefix'     => 'manage',
          'namespace'  => 'Modules\Manage\Http\Controllers',
     ],
     function () {
         Route::get('/notifications', 'NotificationsController@list')->name('notifications-list');
         Route::get('/notifications/markall', 'NotificationsController@markAll');
         Route::get('notifications/{id}/mark', 'NotificationsController@markItem');
         Route::get('notifications/reload', 'NotificationsController@reloadIcon');

     }
);




