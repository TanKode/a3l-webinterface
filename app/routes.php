<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('before' => 'auth', function() {
    switch(Auth::user()->level):
        case 1:
            $level_label = '<span class="label label-info">Support I</span>';
            break;
        case 2:
            $level_label = '<span class="label label-success">Support II</span>';
            break;
        case 3:
            $level_label = '<span class="label label-warning">Support III</span>';
            break;
        case 4:
            $level_label = '<span class="label label-primary">Admin</span>';
            break;
        case 5:
            $level_label = '<span class="label label-danger">Super-Admin</span>';
            break;
        default:
            $level_label = '<span class="label label-default">Mitglied</span>';
            break;
    endswitch;
    $users_count = DB::table('users')->count();
    $players_count = DB::table('players')->count();
    $vehicles_count = DB::table('vehicles')->count();
    return View::make('main')->nest('content', 'dashboard', array('level_label'=>$level_label));
}));

Route::get('/login', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'active', 'register'=>''));
});

Route::get('/register', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'', 'register'=>'active'));
});

Route::controller('user', 'UsersController');