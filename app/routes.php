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
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $counter['users'] = DB::table('users')->count();
    $counter['players'] = DB::table('players')->count();
    $counter['vehicles'] = DB::table('vehicles')->count();
    $counter['houses'] = DB::table('houses')->count();
    $counter['gangs'] = DB::table('gangs')->count();

    $current_player = DB::table('players')->where('playerid', Auth::user()->playerid)->first();
    $current_player->coplevel_name = json_decode(file_get_contents('../app/views/jsons/coplevel.json'))[$current_player->coplevel];
    $current_player->mediclevel_name = json_decode(file_get_contents('../app/views/jsons/mediclevel.json'))[$current_player->mediclevel];
    $current_player->adaclevel_name = json_decode(file_get_contents('../app/views/jsons/adaclevel.json'))[$current_player->adaclevel];

    $current_player_vehicles = DB::table('vehicles')->where('pid', Auth::user()->playerid)->get();

    $licenses = json_decode(file_get_contents('../app/views/jsons/licenses.json'));
    $profs = json_decode(file_get_contents('../app/views/jsons/profs.json'));
    $vehicles = json_decode(file_get_contents('../app/views/jsons/vehicles.json'), true);

    return View::make('main')->nest('content', 'dashboard', array('level_label'=>$level_label, 'counter'=>$counter, 'current_player'=>$current_player, 'licenses'=>$licenses, 'profs'=>$profs, 'vehicles'=>$vehicles, 'current_player_vehicles'=>$current_player_vehicles));
}));

Route::get('/webuser', array('before' => 'auth|admin', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $webusers = DB::table('users')->get();

    return View::make('main')->nest('content', 'webuser', array('level_label'=>$level_label, 'webusers'=>$webusers));
}));

Route::get('/vehicles', array('before' => 'auth|support2', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $all_vehicles = DB::table('vehicles')->get();

    $vehicles = json_decode(file_get_contents('../app/views/jsons/vehicles.json'), true);

    return View::make('main')->nest('content', 'vehicles', array('level_label'=>$level_label, 'vehicles'=>$vehicles, 'all_vehicles'=>$all_vehicles));
}));

Route::get('/players', array('before' => 'auth|support1', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $players = DB::table('players')->get();

    $licenses = json_decode(file_get_contents('../app/views/jsons/licenses.json'));

    return View::make('main')->nest('content', 'players', array('level_label'=>$level_label, 'players'=>$players, 'licenses'=>$licenses));
}));



Route::get('/login', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'active', 'register'=>''));
});

Route::get('/register', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'', 'register'=>'active'));
});

Route::get('/db_user_Setup', function() {
    Schema::create('users', function($table) {
        $table->increments('id');
        $table->bigInteger('playerid');
        $table->string('username', 32);
        $table->string('email', 320);
        $table->string('password', 60);
        $table->tinyInteger('level');
        $table->timestamps();
        $table->rememberToken();
    });

    return View::make('main')->nest('content', 'dashboard');
});

Route::controller('user', 'UsersController');

Route::controller('vehicle', 'VehiclesController');

Route::controller('player', 'PlayersController');