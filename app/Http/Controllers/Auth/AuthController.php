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
        \Mail::send('emails.verification', [
            'user' => $user,
        ], function ($m) use ($user) {
            $m->from('noreply@gummibeer.de', trans('messages.title'));
            $m->to($user->email, $user->name)->subject('E-Mail verification.');
        });
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
        $user = User::confirmToken($token)->first();
        if(!is_null($user)) {
            $user->update([
                'confirmed' => 1,
                'confirmation_token' => '',
            ]);
            \Auth::login($user);

            return redirect($this->redirectPath());
        }
        return redirect('app');
    }
}
