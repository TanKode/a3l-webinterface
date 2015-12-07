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
        Route::get('/{user}', 'UserController@getShow');
        Route::get('/edit/{user}', 'UserController@getEdit');
        Route::post('/edit/{user}', 'UserController@postEdit');
        Route::get('/delete/{user}', 'UserController@getDelete');
    });

    Route::group(['prefix' => 'player'], function () {
        Route::get('/', 'PlayerController@getIndex');
        Route::get('/{player}', 'PlayerController@getShow');
        Route::get('/edit/{player}', 'PlayerController@getEdit');
        Route::post('/edit/{player}', 'PlayerController@postEdit');
        Route::get('/delete/{player}', 'PlayerController@getDelete');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@getIndex');
        Route::get('/{role}', 'RoleController@getShow');
        Route::get('/edit/{role}', 'RoleController@getEdit');
    });
});