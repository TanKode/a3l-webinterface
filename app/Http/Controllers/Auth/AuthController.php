<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, User::$rules['create']);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'player_id' => $data['player_id'],
            'password' => bcrypt($data['password']),
        ]);
        $user->assign('member');
        $user->allow('edit', $user);
        return $user;
    }

    public function getLogin()
    {
        return view('auth')->with([
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
        ]);
    }

    public function getRegister()
    {
        return view('auth')->with([
            'a3lserver' => $this->getLife(),
            'ts3server' => $this->getTeamspeak(),
        ]);
    }
}
