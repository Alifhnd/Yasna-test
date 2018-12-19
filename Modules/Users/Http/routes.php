<?php

/*
|--------------------------------------------------------------------------
| Manage Side
|--------------------------------------------------------------------------
|
*/
Route::group(
     [
          'middleware' => ['web', 'auth', 'is:admin'],
          'prefix'     => 'manage/users/',
          'namespace'  => module('users')->getControllersNamespace(),
     ],
     function () {
         Route::get('/update/{item_id}/{request_role}', 'UsersSearchController@update');
         Route::get('browse/{role}/search', 'UsersSearchController@panel');
         Route::get('browse/{role}/search-for', 'UsersSearchController@search');
         Route::get('browse/{role}/{request_tab?}', 'UsersBrowseController@index');
         Route::get('create/{role}', 'UsersActionController@createForm');
         Route::get('/act/{model_id}/{action}/{option0?}/{option1?}/{option2?}', 'UsersActionController@singleAction');

         Route::group(['prefix' => 'save'], function () {
             Route::post('/', 'UsersActionController@save')->name('user-save');
             //             Route::post('/smsMass', 'UsersController@smsMass');
             //             Route::post('/statusMass', 'UsersController@saveStatusMass');
             //             Route::post('/status', 'UsersController@saveStatus');
             Route::post('/password', 'UsersActionController@savePassword')->name('user-save-password');
             Route::post('/permits', 'UsersActionController@savePermits')->name('user-save-permits');

             Route::post('/block', 'UsersActionController@blockOrUnblock')->name('user-save-block');
             Route::post('/delete', 'UsersActionController@deleteOrUndelete')->name('user-save-delete');
             Route::post('/login_as', 'UsersActionController@loginAs')->name('login_as');

             Route::get('/role/{user_id}/{role_slug}/{new_status}', 'UsersActionController@saveRole');

             Route::get('/profile/{hashid}', 'UsersProfileController@index')->name('user-profile');

             Route::get('/profile-demo', 'UsersProfileController@demo')
                  ->name('user-profile-demo')
                  ->middleware('is:developer');
         });
     }
);


Route::group(
     [
          'middleware' => ['web', 'auth', 'is:super'],
          'prefix'     => 'manage/users/departments',
          'namespace'  => module('users')->getControllersNamespace(),
     ],
     function () {
         Route::get('grid', 'DepartmentsBrowseController@grid')->name('users.departments.grid');

         Route::get('act/{model_id}/{action}/{option0?}/{option1?}/{option2?}', 'DepartmentsController@singleAction')
              ->name('users.departments.single-action')
         ;

         Route::post('save', 'DepartmentsController@save')->name('users.departments.save');
         Route::post('search-member', 'DepartmentsController@searchMember')->name('users.departments.search-member');
         Route::post('add-member', 'DepartmentsController@addMember')->name('users.departments.add-member');
         Route::post('remove-member', 'DepartmentsController@removeMember')->name('users.departments.remove-member');
     }
);
