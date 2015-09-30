<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controller('auth', 'Auth\AuthController');

Route::group(['prefix' => 'app', 'middleware' => 'auth', 'namespace' => 'App'], function() {
    Route::controller('dashboard', 'DashboardController');
    Route::controller('notification', 'NotificationController');
    Route::controller('profile', 'ProfileController');
    Route::controller('changelog', 'ChangelogController');
    Route::controller('issue', 'IssueController');

    Route::group(['prefix' => 'a3l', 'namespace' => 'A3L'], function() {
        Route::controller('player', 'PlayerController');
        Route::controller('vehicle', 'VehicleController');
    });

    // ADMINISTRATION
    Route::controller('donation', 'DonationController');
    Route::controller('accounting', 'AccountingController');

    Route::controller('user', 'UserController');
    Route::controller('role', 'RoleController');
    Route::controller('ability', 'AbilityController');

    Route::controller('setting', 'SettingController');
});

// ALIASES
Route::get('/', function() { return redirect()->to('app/dashboard'); });
Route::get('auth', function() { return redirect()->to('auth/login'); });
Route::get('app', function() { return redirect()->to('app/dashboard'); });