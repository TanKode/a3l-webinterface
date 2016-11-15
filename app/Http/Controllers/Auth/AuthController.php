<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
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
            'confirmation_token' => str_random(32),
        ]);
        $user->assign('member');
        $user->allow('edit', $user);
        $user->sendVerificationEmail();
        if($user->hasPlayer()) {
            $user->player->enableLicense('civ', 'license_civ_fuel');
        }
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

    public function getConfirm($token)
    {
        $user = User::unconfirmed()->confirmToken($token)->first();
        if (!is_null($user)) {
            if ($user->confirm()) {
                \Auth::login($user);
            }

            return redirect($this->redirectPath());
        }
        return redirect('app');
    }
}
