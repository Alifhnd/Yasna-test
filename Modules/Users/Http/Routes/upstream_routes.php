<?php

Route::group(
     [
          'middleware' => ['web', 'auth', 'is:developer'],
          'prefix'     => 'manage/upstream',
          'namespace'  => 'Modules\Users\Http\Controllers',
     ],
     function () {
         Route::get('/roles/{action}/{hash_id?}', 'RolesUpstreamController@action');

         Route::group(['prefix' => 'save'], function () {
             Route::post('/role', 'RolesUpstreamController@save');
             Route::post('/role-activeness', 'RolesUpstreamController@saveActiveness');
             Route::post('/role-admins', 'RolesUpstreamController@saveAllAdmins');
             Route::post('/role-titles', 'RolesUpstreamController@saveTitles');
         });
     }
);
