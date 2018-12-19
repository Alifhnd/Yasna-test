<?php

Route::group([
     'middleware' => 'web',
     'namespace'  => module('Yasna')->getControllersNamespace("Api\\V1"),
     'prefix'     => 'api/v1/settings',
], function () {
    Route::get('/{slug}', 'SettingsController@getSetting');
    Route::get('/', 'SettingsController@getAllSettings');
});
