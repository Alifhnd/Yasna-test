<?php

Route::group(['middleware' => 'web', 'prefix' => 'trans', 'namespace' => 'Modules\Trans\Http\Controllers'], function () {
    Route::get('/', 'TransController@index');
    Route::get('/edit_modal/{hashid}', 'TransController@showEditPage')->name('edit-modal');
    Route::get('/delete_modal/{hashid}', 'TransController@showDeletePage')->name('delete-modal');

    Route::get('/add_modal', 'TransController@showAddPage')->name('add-modal');

    Route::get('/edit', 'TransController@editTrans')->name('edit');
    Route::get('/delete', 'TransController@deleteTrans')->name('delete');

    Route::get('/add', 'TransController@addTrans');
    Route::get('update/row/{hashid}', 'TransController@update');
});

/**
 * |--------------------------------------------------------------------------
 *  Define routes for import and export trans file
 * |--------------------------------------------------------------------------
 */
Route::group([
     'middleware' => ['web', 'auth', 'is:developer'],
     'prefix'     => 'manage/trans/upstream/',
     'namespace'  => 'Modules\Trans\Http\Controllers',
], function () {
    Route::get('export', 'ExportTransController@exportModal')->name('manage.trans.export_modal');
    Route::post('export', 'ExportTransController@export')->name('manage.trans.export');
    Route::get('download', 'ExportTransController@download')->name('manage.trans.download');

    Route::get('import', 'ImportTransController@importModal')->name('manage.trans.import_modal');
    Route::post('import', 'ImportTransController@import')->name('manage.trans.import');
});
