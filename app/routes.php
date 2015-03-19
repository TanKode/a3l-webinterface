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
    $counter['admins'] = DB::table('players')->where('adminlevel', '>', 0)->count();
    $counter['cops'] = DB::table('players')->where('coplevel', '>', 0)->count();
    $counter['medics'] = DB::table('players')->where('mediclevel', '>', 0)->count();
    $counter['adac'] = DB::table('players')->where('adaclevel', '>', 0)->count();
    $counter['donators'] = DB::table('players')->where('donatorlvl', '>', 0)->count();
    $counter['vehicles'] = DB::table('vehicles')->count();
    $counter['vehicles_destroyed'] = DB::table('vehicles')->where('alive', 0)->count();
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

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label))->nest('content', 'dashboard', array('level_label'=>$level_label, 'counter'=>$counter, 'current_player'=>$current_player, 'licenses'=>$licenses, 'profs'=>$profs, 'vehicles'=>$vehicles, 'current_player_vehicles'=>$current_player_vehicles, 'database'=>$database));
}));

Route::get('/webuser', array('before' => 'auth|admin', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $webusers = DB::table('users')->get();

    return View::make('main', array('level_label'=>$level_label))->nest('content', 'webuser', array('level_label'=>$level_label, 'webusers'=>$webusers));
}));

Route::get('/vehicles', array('before' => 'auth|support2', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $search = Input::get('s');
    $type = Input::get('t');

    if(!empty($search)) {
        $all_vehicles = DB::table('vehicles')
            ->where('pid', 'LIKE', '%'.$search.'%')
            ->orWhere('classname', 'LIKE', '%'.$search.'%')
            ->get();
    } elseif(!empty($type)) {
        switch($type):
            case 'alive':
                $where = array('alive', 1);
                break;
            case 'destroyed':
                $where = array('alive', 0);
                break;
        endswitch;

        $all_vehicles = DB::table('vehicles')
            ->where($where[0], $where[1])
            ->get();
    } else {
        $all_vehicles = DB::table('vehicles')->get();
    }

    $vehicles = json_decode(file_get_contents('../app/views/jsons/vehicles.json'), true);

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label))->nest('content', 'vehicles', array('level_label'=>$level_label, 'vehicles'=>$vehicles, 'all_vehicles'=>$all_vehicles, 'database'=>$database, 'search'=>$search));
}));

Route::get('/players', array('before' => 'auth|support1', function() {
    $level_label[0] = '<span class="label label-default">Mitglied</span>';
    $level_label[1] = '<span class="label label-info">Support I</span>';
    $level_label[2] = '<span class="label label-success">Support II</span>';
    $level_label[3] = '<span class="label label-warning">Support III</span>';
    $level_label[4] = '<span class="label label-primary">Admin</span>';
    $level_label[5] = '<span class="label label-danger">Super-Admin</span>';

    $search = Input::get('s');
    $type = Input::get('t');

    if(!empty($search)) {
        $players = DB::table('players')
            ->where('playerid', 'LIKE', '%'.$search.'%')
            ->orWhere('name', 'LIKE', '%'.$search.'%')
            ->orWhere('aliases', 'LIKE', '%'.$search.'%')
            ->get();
    } elseif(!empty($type)) {
        switch($type):
            case 'cops':
                $where = array('coplevel', '>', 0);
                break;
            case 'medics':
                $where = array('mediclevel', '>', 0);
                break;
            case 'adac':
                $where = array('adaclevel', '>', 0);
                break;
            case 'donator':
                $where = array('donatorlvl', '>', 0);
                break;
            case 'admins':
                $where = array('adminlevel', '>', 0);
                break;
        endswitch;

        $players = DB::table('players')
            ->where($where[0], $where[1], $where[2])
            ->get();
    } else {
        $players = DB::table('players')->get();
    }

    $licenses = json_decode(file_get_contents('../app/views/jsons/licenses.json'));
    $coplevel = json_decode(file_get_contents('../app/views/jsons/coplevel.json'));
    $mediclevel = json_decode(file_get_contents('../app/views/jsons/mediclevel.json'));
    $adaclevel = json_decode(file_get_contents('../app/views/jsons/adaclevel.json'));

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label))->nest('content', 'players', array('level_label'=>$level_label, 'players'=>$players, 'licenses'=>$licenses, 'database'=>$database, 'coplevel'=>$coplevel, 'mediclevel'=>$mediclevel, 'adaclevel'=>$adaclevel, 'search'=>$search));
}));



Route::get('/login', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'active', 'register'=>''));
});

Route::get('/register', function() {
    return View::make('main')->nest('content', 'login_register', array('login'=>'', 'register'=>'active'));
});

Route::controller('user', 'UsersController');

Route::controller('vehicle', 'VehiclesController');

Route::controller('player', 'PlayersController');