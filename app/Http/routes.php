<?php
Route::get('/', function () { return redirect('app/dashboard'); });
Route::get('app', function () { return redirect('app/dashboard'); });
Route::get('home', function () { return redirect('app/dashboard'); });
Route::get('auth', function () { return redirect('auth/login'); });

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');
    Route::get('logout', 'AuthController@getLogout');
});

Route::group(['prefix' => 'app', 'namespace' => 'App', 'middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@getIndex');

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@getIndex');
    });
});