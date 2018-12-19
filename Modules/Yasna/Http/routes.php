<?php
Route::group([
    'middleware' => "web",
    'namespace'  => 'Modules\Yasna\Http\Controllers\Auth',
],
    function () {
        /*-----------------------------------------------
        | Login ...
        */
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('home', 'LoginController@home')->name('home');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::get('logout', 'LoginController@logout');
        Route::get('/', 'LoginController@showLoginForm');

        /*-----------------------------------------------
        | Register ...
        */
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        /*-----------------------------------------------
        | Password Reset ...
        */
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/reset', 'ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        //Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    }
);
