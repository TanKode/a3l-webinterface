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

$level_label = array();
$level_label[0] = '<span class="label label-default">Mitglied</span>';
$level_label[1] = '<span class="label label-info">Support I</span>';
$level_label[2] = '<span class="label label-success">Support II</span>';
$level_label[3] = '<span class="label label-warning">Support III</span>';
$level_label[4] = '<span class="label label-primary">Admin</span>';
$level_label[5] = '<span class="label label-danger">Super-Admin</span>';

$counter = array();
$counter['users'] = DB::table('users')->count();
$counter['players'] = DB::table('players')->count();
$counter['admins'] = DB::table('players')->where('adminlevel', '>', 0)->count();
$counter['cops'] = DB::table('players')->where('coplevel', '>', 0)->count();
$counter['medics'] = DB::table('players')->where('mediclevel', '>', 0)->count();
$counter['adac'] = DB::table('players')->where('adaclevel', '>', 0)->count();
$counter['donators'] = DB::table('players')->where('donatorlvl', '>', 0)->count();
$counter['cash'] = DB::table('players')->sum('cash');
$counter['bank'] = DB::table('players')->sum('bankacc');
$counter['vehicles'] = DB::table('vehicles')->count();
$counter['vehicles_destroyed'] = DB::table('vehicles')->where('alive', 0)->count();
$counter['houses'] = DB::table('houses')->count();
$counter['gangs'] = DB::table('gangs')->count();
$counter['logs'] = DB::table('logs')->count();

Route::get('/', array('before' => 'auth', function() use ($level_label, $counter) {
    $current_player = DB::table('players')->where('playerid', Auth::user()->playerid)->first();
    $current_player->coplevel_name = json_decode(file_get_contents('../app/views/jsons/coplevel.json'))[$current_player->coplevel];
    $current_player->mediclevel_name = json_decode(file_get_contents('../app/views/jsons/mediclevel.json'))[$current_player->mediclevel];
    $current_player->adaclevel_name = json_decode(file_get_contents('../app/views/jsons/adaclevel.json'))[$current_player->adaclevel];

    $date = new DateTime($current_player->donatordate);
    $duration = $current_player->donatorduration < 1 ? 1 : $current_player->donatorduration;
    $date->modify('+'.$duration.' month');
    $current_player->donatorexpires = $date->format('d.m.Y');

    $playernames = unserialize(Auth::user()->playernames) ? unserialize(Auth::user()->playernames) : array();
    $playernames[] = $current_player->name;
    $playernames = array_unique($playernames);
    $current_player->aliases = implode(', ', $playernames);
    $playernames = serialize($playernames);
    DB::table('users')->where('playerid', Auth::user()->playerid)->update(array('playernames' => $playernames));

    $current_player_vehicles = DB::table('vehicles')->where('pid', Auth::user()->playerid)->get();
    $all_vehicles = DB::table('vehicles')->get();

    $licenses = json_decode(file_get_contents('../app/views/jsons/licenses.json'));
    $profs = json_decode(file_get_contents('../app/views/jsons/profs.json'));
    $vehicles = json_decode(file_get_contents('../app/views/jsons/vehicles.json'), true);
    $cartaxes = json_decode(file_get_contents('../app/views/jsons/cartax.json'), true);

    $current_player_cartax = 0;
    foreach($current_player_vehicles as $vehicle):
        if(Config::get('a3lwi.cartax.1.'.$vehicle->side)):
            if(isset($cartaxes[$vehicle->classname])):
                if($vehicle->type == 'Air'):
                    $current_player_cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3') + Config::get('a3lwi.cartax.4');
                elseif(in_array($vehicle->classname, Config::get('a3lwi.cartax.6'))):
                    $current_player_cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3') + Config::get('a3lwi.cartax.5');
                else:
                    $current_player_cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3');
                endif;
            else:
                $current_player_cartax += Config::get('a3lwi.cartax.2') * Config::get('a3lwi.cartax.3');
            endif;
        endif;
    endforeach;

    $cartax = 0;
    foreach($all_vehicles as $vehicle):
        if(Config::get('a3lwi.cartax.1.'.$vehicle->side)):
            if(isset($cartaxes[$vehicle->classname])):
                if($vehicle->type == 'Air'):
                    $cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3') + Config::get('a3lwi.cartax.4');
                elseif(in_array($vehicle->classname, Config::get('a3lwi.cartax.6'))):
                    $cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3') + Config::get('a3lwi.cartax.5');
                else:
                    $cartax += $cartaxes[$vehicle->classname] * Config::get('a3lwi.cartax.3');
                endif;
            else:
                $cartax += Config::get('a3lwi.cartax.2') * Config::get('a3lwi.cartax.3');
            endif;
        endif;
    endforeach;

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'dashboard', array('level_label'=>$level_label, 'counter'=>$counter, 'current_player'=>$current_player, 'licenses'=>$licenses, 'profs'=>$profs, 'vehicles'=>$vehicles, 'current_player_vehicles'=>$current_player_vehicles, 'current_player_cartax'=>$current_player_cartax, 'cartax'=>$cartax, 'database'=>$database));
}));

Route::get('/webuser', array('before' => 'auth|admin', function() use ($level_label, $counter) {
    $webusers = DB::table('users')->orderBy('level', 'desc')->paginate(25);

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'webuser', array('level_label'=>$level_label, 'webusers'=>$webusers));
}));

Route::get('/vehicles', array('before' => 'auth|support2', function() use ($level_label, $counter) {
    $search = Input::get('s');
    $type = Input::get('t');

    if(!empty($search)) {
        $all_vehicles = DB::table('vehicles')
            ->where('pid', 'LIKE', '%'.$search.'%')
            ->orWhere('id', $search)
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
        $all_vehicles = DB::table('vehicles')->paginate(50);
    }

    $vehicles = json_decode(file_get_contents('../app/views/jsons/vehicles.json'), true);

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'vehicles', array('level_label'=>$level_label, 'vehicles'=>$vehicles, 'all_vehicles'=>$all_vehicles, 'database'=>$database, 'search'=>$search, 'type'=>$type));
}));

Route::get('/players', array('before' => 'auth|support1', function() use ($level_label, $counter) {
    $search = Input::get('s');
    $type = Input::get('t');

    if(!empty($search)) {
        $players = DB::table('players')
            ->where('playerid', 'LIKE', '%'.$search.'%')
            ->orWhere('uid', $search)
            ->orWhere('name', 'LIKE', '%'.$search.'%')
            ->orWhere('aliases', 'LIKE', '%'.$search.'%')
            ->get();
    } elseif(!empty($type)) {
        switch($type):
            case 'cops':
                $where = array('coplevel', '>', 0);
                $order = 'coplevel';
                break;
            case 'medics':
                $where = array('mediclevel', '>', 0);
                $order = 'mediclevel';
                break;
            case 'adac':
                $where = array('adaclevel', '>', 0);
                $order = 'adaclevel';
                break;
            case 'donator':
                $where = array('donatorlvl', '>', 0);
                $order = 'donatorlvl';
                break;
            case 'admins':
                $where = array('adminlevel', '>', 0);
                $order = 'adminlevel';
                break;
        endswitch;

        $players = DB::table('players')
            ->where($where[0], $where[1], $where[2])
            ->orderBy($order, 'desc')
            ->get();
    } else {
        $players = DB::table('players')->paginate(50);
    }

    $licenses = json_decode(file_get_contents('../app/views/jsons/licenses.json'));
    $coplevel = json_decode(file_get_contents('../app/views/jsons/coplevel.json'));
    $mediclevel = json_decode(file_get_contents('../app/views/jsons/mediclevel.json'));
    $adaclevel = json_decode(file_get_contents('../app/views/jsons/adaclevel.json'));

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'players', array('level_label'=>$level_label, 'players'=>$players, 'licenses'=>$licenses, 'database'=>$database, 'coplevel'=>$coplevel, 'mediclevel'=>$mediclevel, 'adaclevel'=>$adaclevel, 'search'=>$search, 'type'=>$type));
}));

Route::get('/gangs', array('before' => 'auth|support2', function() use ($level_label, $counter) {
    $search = Input::get('s');

    if(!empty($search)) {
        $gangs = DB::table('gangs')
            ->where('id', 'LIKE', '%'.$search.'%')
            ->orWhere('owner', 'LIKE', '%'.$search.'%')
            ->get();
    } else {
        $gangs = DB::table('gangs')->paginate(25);
    }

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'gangs', array('level_label'=>$level_label, 'gangs'=>$gangs, 'database'=>$database, 'search'=>$search));
}));

Route::get('/logs', array('before' => 'auth|support1', function() use ($level_label, $counter) {
    $search = Input::get('s');
    $type = Input::get('t');

    if(!empty($search)) {
        switch($search[0]):
            case 'e':
                $logs = DB::table('logs')->where('editor', substr($search, 1))->orderBy('created_at', 'desc')->get();
                break;
            case 'v':
                $logs = DB::table('logs')
                    ->where(function($query) use ($search) {
                        $query->where('objectid', substr($search, 1))->where('type', 'vehicle');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 'g':
                $logs = DB::table('logs')
                    ->where(function($query) use ($search) {
                        $query->where('objectid', substr($search, 1))->where('type', 'gang');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 'p':
                $logs = DB::table('logs')
                    ->where('playerid', substr($search, 1))
                    ->orWhere('objectid', 'LIKE', '%'.$search.'%')
                    ->orWhere(function($query) use ($search) {
                        $query->where('objectid', substr($search, 1))->where('type', 'player');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            case 'd':
                $logs = DB::table('logs')
                    ->where('created_at', 'LIKE', substr($search, 1) . '%')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
            default:
                $logs = DB::table('logs')
                    ->where('editor', 'LIKE', '%'.$search.'%')
                    ->orWhere('objectid', 'LIKE', '%'.$search.'%')
                    ->orWhere('playerid', 'LIKE', '%'.$search.'%')
                    ->orderBy('created_at', 'desc')
                    ->get();
                break;
        endswitch;
    } elseif(!empty($type)) {
        switch($type):
            case 'p':
                $where = 'player';
                break;
            case 'g':
                $where = 'gang';
                break;
            case 'v':
                $where = 'vehicle';
                break;
            default:
                $where = '%';
                break;
        endswitch;

        $logs = DB::table('logs')
            ->where('type', $where)
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        $logs = DB::table('logs')->orderBy('created_at', 'desc')->paginate(100);
    }

    foreach($logs as $key => $log) {
        $logs[$key]->editor_name = User::find($log->editor)->username;
        $logs[$key]->difference = unserialize($log->difference);
        $logs[$key]->differences = array();
        foreach($logs[$key]->difference as $differencekey => $difference) {
            $logs[$key]->differences[] = array($differencekey, $difference[0], $difference[1]);
        }
        $log->search_letter = strtolower(substr($log->type, 0, 1));
        switch($log->type):
            case 'player':
                $logs[$key]->type = 'Spieler';
                $logs[$key]->object_name = Player::find($log->objectid)['name'];
                break;
            case 'gang':
                $logs[$key]->type = 'Gang';
                $logs[$key]->object_name = Gang::find($log->objectid)['name'];
                break;
            case 'vehicle':
                $logs[$key]->type = 'Fahrzeug';
                $logs[$key]->object_name = Vehicle::find($log->objectid)['classname'];
                break;
        endswitch;
    }

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'logs', array('level_label'=>$level_label, 'logs'=>$logs, 'search'=>$search, 'type'=>$type));
}));

Route::get('/statistics', array('before' => 'auth', function() use ($level_label, $counter) {
    $statistics = DB::table('statistics')->orderBy('timestamp', 'asc')->get();

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'statistics', array('level_label'=>$level_label, 'statistics'=>$statistics));
}));

Route::get('/donators', array('before' => 'auth|admin', function() use ($level_label, $counter) {
    $donators = DB::table('players')->where('donatorlvl', '>', 0)->paginate(50);

    foreach($donators as $key => $donator) {
        $date = new DateTime($donator->donatordate);
        $duration = $donator->donatorduration < 1 ? 1 : $donator->donatorduration;
        $date->modify('+'.$duration.' month');
        $donators[$key]->donatorexpires = $date->format('d.m.Y');
    }

    $database = DB::getConfig('database');

    return View::make('main', array('level_label'=>$level_label, 'counter'=>$counter))->nest('content', 'donator', array('level_label'=>$level_label, 'database'=>$database, 'donators'=>$donators));
}));



Route::get('/clearcache', array('before' => 'auth|superadmin|nocache', function() {
    return Redirect::to('/')->with(array('message'=>'Seiten-Cache wurde gelöscht.', 'type' => 'success'));
}));


Route::get('/login', function() {
    if(Auth::check()) {
        return Redirect::to('/');
    } else {
        return View::make('main')->nest('content', 'login_register', array('login'=>'active', 'register'=>''));
    }
});

Route::get('/register', function() {
    if(Auth::check()) {
        return Redirect::to('/');
    } else {
        return View::make('main')->nest('content', 'login_register', array('login'=>'', 'register'=>'active'));
    }
});

Route::controller('user', 'UsersController');

Route::controller('vehicle', 'VehiclesController');

Route::controller('player', 'PlayersController');

Route::controller('gang', 'GangsController');

Route::controller('donators', 'DonatorsController');