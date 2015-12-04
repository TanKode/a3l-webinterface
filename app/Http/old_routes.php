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

Route::get('steam/login', ['as' => 'steam.login', 'uses' => 'Auth\SteamController@getLogin']);

// FINISHED
Route::get('/', ['uses' => 'HomeController@index']);

Route::group(['prefix' => 'sys'], function () {
    Route::get('info', ['as' => 'db.list', 'uses' => 'SystemController@info']);
    Route::get('load', ['as' => 'db.backup', 'uses' => 'SystemController@load']);
});

Route::group(['prefix' => 'db'], function () {
    Route::get('status', ['as' => 'db.list', 'uses' => 'DatabaseController@index']);
    Route::get('download/{filename}', ['as' => 'db.download', 'uses' => 'DatabaseController@download']);
    Route::get('delete/{filename}', ['as' => 'db.delete', 'uses' => 'DatabaseController@delete']);
});

Route::get('weblog/{parameters?}', ['as' => 'weblog', 'uses' => 'WeblogController@index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('list', ['as' => 'user.list', 'uses' => 'UserController@index']);
    Route::get('edit/{id}', ['as' => 'user.edit', 'uses' => 'UserController@edit']);
    Route::post('update/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
    Route::post('delete/{id}', ['as' => 'user.delete', 'uses' => 'UserController@destroy']);
});

Route::group(['prefix' => 'player'], function () {
    Route::get('list', ['as' => 'player.list', 'uses' => 'PlayerController@index']);
    Route::get('edit/{id}', ['as' => 'player.edit', 'uses' => 'PlayerController@edit']);
    Route::post('update/{id}', ['as' => 'player.update', 'uses' => 'PlayerController@update']);
    Route::get('profile/{id}', ['as' => 'player.profile', 'uses' => 'PlayerController@show']);
});

Route::group(['prefix' => 'donator'], function () {
    Route::get('list', ['as' => 'donator.list', 'uses' => 'DonatorHistoryController@index']);
    Route::post('add', ['as' => 'donator.add', 'uses' => 'DonatorHistoryController@store']);
    Route::get('history/{id}', ['as' => 'donator.history', 'uses' => 'DonatorHistoryController@history']);
    Route::post('delete/{id}', ['as' => 'donator.delete', 'uses' => 'DonatorHistoryController@destroy']);
});

Route::group(['prefix' => 'gang'], function () {
    Route::get('list', ['as' => 'gang.list', 'uses' => 'GangController@index']);
    Route::get('edit/{id}', ['as' => 'gang.edit', 'uses' => 'GangController@edit']);
    Route::post('update/{id}', ['as' => 'gang.update', 'uses' => 'GangController@update']);
});

Route::group(['prefix' => 'vehicle'], function () {
    Route::get('list', ['as' => 'vehicle.list', 'uses' => 'VehicleController@index']);
    Route::get('edit/{id}', ['as' => 'vehicle.edit', 'uses' => 'VehicleController@edit']);
    Route::post('update/{id}', ['as' => 'vehicle.update', 'uses' => 'VehicleController@update']);
    Route::post('delete/{id}', ['as' => 'vehicle.delete', 'uses' => 'VehicleController@destroy']);
});

Route::group(['prefix' => 'role'], function () {
    Route::get('list', ['as' => 'role.list', 'uses' => 'RoleController@index']);
    Route::get('edit/{id}', ['as' => 'role.edit', 'uses' => 'RoleController@edit']);
    Route::post('add', ['as' => 'role.add', 'uses' => 'RoleController@store']);
    Route::post('update/{id}', ['as' => 'role.update', 'uses' => 'RoleController@update']);
});

Route::group(['prefix' => 'permission'], function () {
    Route::get('list', ['as' => 'permission.list', 'uses' => 'PermissionController@index']);
    Route::get('edit/{id}', ['as' => 'permission.edit', 'uses' => 'PermissionController@edit']);
    Route::post('add', ['as' => 'permission.add', 'uses' => 'PermissionController@store']);
    Route::post('update/{id}', ['as' => 'permission.update', 'uses' => 'PermissionController@update']);
});

Route::group(['prefix' => 'setting'], function () {
    Route::get('list', ['as' => 'setting.list', 'uses' => 'SettingController@index']);
    Route::post('add', ['as' => 'setting.add', 'uses' => 'SettingController@store']);
    Route::post('update/{id}', ['as' => 'setting.update', 'uses' => 'SettingController@update']);
    Route::get('delete/{id}', ['as' => 'setting.delete', 'uses' => 'SettingController@destroy']);
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

$redirect = Redirect::to('/');

Entrust::routeNeedsRoleOrPermission('player/list', array('super_admin'), array('view_players'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('player/edit', array('super_admin'), array('edit_player'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('player/update', array('super_admin'), array('edit_player'), $redirect, false);

Entrust::routeNeedsRoleOrPermission('donator/list', array('super_admin'), array('view_donators'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('donator/add', array('super_admin'), array('add_donator'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('donator/delete/*', array('super_admin'), array('delete_donator'), $redirect, false);

Entrust::routeNeedsRoleOrPermission('gang/list', array('super_admin'), array('view_gangs'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('gang/edit/*', array('super_admin'), array('edit_gang'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('gang/update/*', array('super_admin'), array('edit_gang'), $redirect, false);

// FINISHED
Entrust::routeNeedsRoleOrPermission('user/list', array('super_admin'), array('view_users'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('user/edit/*', array('super_admin'), array('edit_user'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('user/update/*', array('super_admin'), array('edit_user'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('user/delete/*', array('super_admin'), array('delete_user'), $redirect, false);

Entrust::routeNeedsRoleOrPermission('vehicle/list', array('super_admin'), array('view_vehicles'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('vehicle/edit/*', array('super_admin'), array('edit_vehicle'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('vehicle/update/*', array('super_admin'), array('edit_vehicle'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('vehicle/delete/*', array('super_admin'), array('delete_vehicle'), $redirect, false);

Entrust::routeNeedsRoleOrPermission('role/*', array('super_admin'), array('manage_roles'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('permission/*', array('super_admin'), array('manage_permissions'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('setting/*', array('super_admin'), array('manage_settings'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('weblog', array('super_admin'), array('view_weblog'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('db/status', array('super_admin'), array('view_database'), $redirect, false);
Entrust::routeNeedsRoleOrPermission('db/download', array('super_admin'), array('view_database'), $redirect, false);