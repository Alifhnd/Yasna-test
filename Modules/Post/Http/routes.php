<?php

//Route::group([
//	'middleware' => 'web',
//	'prefix' => 'post',
//	'namespace' => 'Modules\Post\Http\Controllers'
//], function () {
////    Route::get('/', 'PostsController@index');
//});


Route::group([
     'prefix'=>'manage/posts' ,
     'middleware'=>['web','auth'],
     'namespace'  => 'Modules\Post\Http\Controllers',
],function() {
    Route::get('/', 'PostsController@index')->name('posts');
    Route::get('create', 'PostsController@create')->name('posts.create');
    Route::post('store', 'PostsController@store')->name('posts.store');
    //Route::get('delete/{post_id}', 'PostsController@delete')->name('posts.delete');
    //Route::get('edit/{post_id}', 'PostsController@edit')->name('posts.edit');
    //Route::post('update/{post_id}', 'PostsController@update')->name('posts.update');
});
Route::group([
     'prefix'=>'manage/tags' ,
     'middleware'=>['web','auth'],
     'namespace'  => 'Modules\Post\Http\Controllers',
],function() {
    Route::get('create', 'TagsController@create')->name('tags.create');
    Route::post('store', 'TagsController@store')->name('tags.store');
    //Route::get('delete/{post_id}', 'PostsController@delete')->name('posts.delete');
    //Route::get('edit/{post_id}', 'PostsController@edit')->name('posts.edit');
    //Route::post('update/{post_id}', 'PostsController@update')->name('posts.update');
});