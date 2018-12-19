<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test', function () {
    return trans("yasna::people.jafar") ;
});

//Auth::routes();
//Route::get('/logout' , 'Auth\LoginController@logout');
//Route::get('/home', 'HomeController@index')->name('home');
