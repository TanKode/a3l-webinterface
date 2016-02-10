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
    Route::get('test', 'DashboardController@getTest');

    Route::group(['prefix' => 'lotto'], function () {
        Route::get('/', 'LottoController@getIndex');
        Route::post('/bet', 'LottoController@postBet');
    });

    Route::group(['prefix' => 'calendar'], function () {
        Route::get('/', 'CalendarController@getIndex');
        Route::post('/add-event', 'CalendarController@postAddEvent');
        Route::get('/delete-event/{event}', 'CalendarController@getDeleteEvent');
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::get('/', 'ChatController@getIndex');
        Route::get('/create', 'ChatController@getCreate');
        Route::post('/create', 'ChatController@postCreate');
        Route::get('/{chat_thread}', 'ChatController@getShow');
        Route::post('/{chat_thread}', 'ChatController@postReply');
    });

    Route::group(['prefix' => 'message'], function () {
        Route::get('/', 'MessageController@getIndex');
        Route::get('/{player}', 'MessageController@getShow');
    });

    Route::group(['prefix' => 'forum', 'namespace' => 'Forum'], function () {
        Route::get('/', 'CategoryController@getIndex');
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'CategoryController@getIndex');
            Route::get('/create', 'CategoryController@getCreate');
            Route::post('/create', 'CategoryController@postCreate');
            Route::get('/edit/{forum_category}', 'CategoryController@getEdit');
            Route::post('/edit/{forum_category}', 'CategoryController@postEdit');
            Route::get('/delete/{forum_category}', 'CategoryController@getDelete');
            Route::get('/{forum_category}', 'CategoryController@getShow');

            Route::group(['prefix' => '{forum_category}/thread'], function () {
                Route::get('/create', 'ThreadController@getCreate');
                Route::post('/create', 'ThreadController@postCreate');
                Route::get('/{forum_thread}', 'ThreadController@getShow');
                Route::post('/{forum_thread}/reply', 'ThreadController@postReply');
            });
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@getIndex');
        Route::get('/edit/{user}', 'UserController@getEdit');
        Route::post('/edit/{user}', 'UserController@postEdit');
        Route::get('/delete/{user}', 'UserController@getDelete');
        Route::get('/{user}', 'UserController@getShow');
        Route::get('/read-notify/{notification}', 'UserController@getReadNotify');
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
        Route::get('/edit/{vehicle}', 'VehicleController@getEdit');
        Route::post('/edit/{vehicle}', 'VehicleController@postEdit');
        Route::get('/delete/{vehicle}', 'VehicleController@getDelete');
        Route::get('/{vehicle}', 'VehicleController@getShow');
    });

    Route::group(['prefix' => 'backup'], function () {
        Route::get('/', 'BackupController@getIndex');
        Route::get('/download', 'BackupController@getDownload');
        Route::get('/delete', 'BackupController@getDelete');
    });
});