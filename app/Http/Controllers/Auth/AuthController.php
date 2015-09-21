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

    protected $redirectAfterLogout = 'auth/login';
    protected $loginPath = 'auth/login';
    protected $redirectTo = 'app/dashboard';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        return view('auth');
    }

    public function getRegister()
    {
        return view('auth');
    }

    public function getFacebook()
    {
        return \Socialite::driver('facebook')->redirect();
    }

    public function getFacebookcallback(Request $request)
    {
        $response = \Socialite::driver('facebook')->user();
        return $this->handleOauthUser($request, 'facebook', $response);
    }

    public function getGithub()
    {
        return \Socialite::driver('github')->redirect();
    }

    public function getGithubcallback(Request $request)
    {
        $response = \Socialite::driver('github')->user();
        return $this->handleOauthUser($request, 'github', $response);
    }

    private function handleOauthUser($request, $provider, $oAuthUser)
    {
        $user = User::$provider($oAuthUser->getId())->first();
        if(is_null($user)) {
            $user = User::email($oAuthUser->getEmail())->first();
            if(!is_null($user)) {
                $user->saveOauthId($provider, $oAuthUser->getId());
            }
        }
        if(is_null($user)) {
            $user = User::create([
                $provider => $oAuthUser->getId(),
                'username' => is_null($oAuthUser->getNickname()) ? $oAuthUser->getName() : $oAuthUser->getNickname(),
                'email' => $oAuthUser->getEmail(),
            ]);
        }

        \Auth::login($user);
        return $this->handleUserWasAuthenticated($request, $this->isUsingThrottlesLoginsTrait());
    }
}
