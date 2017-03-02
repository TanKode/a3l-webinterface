<?php

Route::get('/', function () {
    return redirect('app/dashboard');
});
Route::get('app', function () {
    return redirect('app/dashboard');
});
Route::get('home', function () {
    return redirect('app/dashboard');
});
Route::get('auth', function () {
    return redirect('auth/login');
});

Route::get('page/{page}', 'PageController@getShow');

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');
    Route::get('logout', 'AuthController@getLogout');
    Route::get('confirm/{token}', 'AuthController@getConfirm');
});

Route::group(['prefix' => 'app', 'namespace' => 'App', 'middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@getIndex');

    Route::group(['prefix' => 'wanted'], function () {
        Route::get('/', 'WantedController@getIndex');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@getIndex');
        Route::get('/edit/{user}', 'UserController@getEdit');
        Route::post('/edit/{user}', 'UserController@postEdit');
        Route::get('/delete/{user}', 'UserController@getDelete');
        Route::get('/read-notify/{notification}', 'UserController@getReadNotify');
        Route::get('/send-verify-mail/{user}', 'UserController@getSendVerificationMail');
        Route::get('/verify-mail/{user}', 'UserController@getVerifyMail');
        Route::get('/{user}', 'UserController@getShow');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@getIndex');
        Route::get('/edit/{role}', 'RoleController@getEdit');
        Route::post('/edit/{role}', 'RoleController@postEdit');
        Route::get('/create', 'RoleController@getCreate');
        Route::post('/create', 'RoleController@postCreate');
        Route::get('/delete/{role}', 'RoleController@getDelete');
        Route::get('/{role}', 'RoleController@getShow');
    });

    Route::group(['prefix' => 'player'], function () {
        Route::get('/', 'PlayerController@getIndex');
        Route::get('/edit/{player}', 'PlayerController@getEdit');
        Route::post('/edit/{player}', 'PlayerController@postEdit');
        Route::get('/delete/{player}', 'PlayerController@getDelete');
        Route::get('/{player}', 'PlayerController@getShow');
    });

    Route::group(['prefix' => 'vehicle'], function () {
        Route::get('/', 'VehicleController@getIndex');
        Route::get('/datatable', 'VehicleController@getDatatable');
        Route::get('/insure', 'VehicleController@getInsure');
        Route::post('/insure', 'VehicleController@postInsure');
        Route::get('/edit/{vehicle}', 'VehicleController@getEdit');
        Route::post('/edit/{vehicle}', 'VehicleController@postEdit');
        Route::get('/delete/{vehicle}', 'VehicleController@getDelete');
        Route::get('/{vehicle}', 'VehicleController@getShow');
    });
});
