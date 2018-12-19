<?php

Route::group([
     'middleware' => ['web', 'auth', 'is:super'],
     'namespace'  => module('Manage')->getControllersNamespace(),
     'prefix'     => 'manage/support',
], function () {
    Route::get('new', 'SupportController@new')->name('manage.support.new');
    Route::post('save', 'SupportController@save')->name('manage.support.save');
    Route::get('tickets/{type}', 'SupportController@list')->name('manage.support.list');
    Route::get('tickets/{type}/{hashid}', 'SupportController@single')->name('manage.support.single');
    Route::post('tickets/{type}/{hashid}/reply', 'SupportController@reply')->name('manage.support.reply');
});
