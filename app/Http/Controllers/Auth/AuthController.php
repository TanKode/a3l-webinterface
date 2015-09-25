<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserCreated;
use App\User;
use Fenos\Notifynder\Builder\NotifynderBuilder;
use Illuminate\Http\Request;
use Invisnik\LaravelSteamAuth\SteamAuth;
use Silber\Bouncer\Database\Role;
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
        $this->middleware('guest', [
            'except' => [
                'getLogout',
                'getSteam',
                'getSteamcallback',
                'getSlack',
                'getSlackcallback',
                'getFacebook',
                'getFacebookcallback',
                'getGithub',
                'getGithubcallback',
            ],
        ]);
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
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        event(new UserCreated($user));
        return $user;
    }

    public function getLogin()
    {
        return view('auth');
    }

    public function getRegister()
    {
        return view('auth');
    }

    public function getSteam(SteamAuth $steam)
    {
        return $steam->redirect();
    }

    public function getSteamcallback(SteamAuth $steam)
    {
        if (\Auth::check()) {
            if ($steam->validate()) {
                $info = $steam->getUserInfo();
                if (!is_null($info)) {
                    \Auth::User()->saveOauthId('steam', $info->getSteamID64());
                    return redirect('app/profile/edit/'.\Auth::User()->id);
                }
            }
        }
        return redirect('/');
    }

    public function getSlack(Request $request)
    {
        if(\Auth::check() && !is_null(\Auth::User()->slack)) {
            return redirect('auth/slackcallback');
        } else {
            $params = [
                'client_id' => config('services.slack.client_id'),
                'redirect_uri' => config('services.slack.redirect'),
                'scope' => 'identify,read',
                'team' => 'T0442S8AK',
            ];
            $url = 'https://slack.com/oauth/authorize?' . http_build_query($params);
            return redirect($url);
        }
    }

    public function getSlackcallback(Request $request)
    {
        $code = \Input::get('code', false);
        if($code) {
            $data = [
                'client_id' => config('services.slack.client_id'),
                'client_secret' => config('services.slack.client_secret'),
                'redirect_uri' => config('services.slack.redirect'),
                'code' => $code,
            ];
            $url = 'https://slack.com/api/oauth.access?'.http_build_query($data);
            $response = \Curl::get($url);
            $response['body'] = json_decode($response['body'], true);
            if($response['body']['ok']) {
                $token = $response['body']['access_token'];

                $data = [
                    'token' => $token,
                ];
                $url = 'https://slack.com/api/auth.test?' . http_build_query($data);
                $response = \Curl::get($url);
                $response['body'] = json_decode($response['body'], true);
                if ($response['body']['ok']) {
                    $userId = $response['body']['user_id'];
                }
            }
        } elseif(\Auth::check() && !is_null(\Auth::User()->slack)) {
            $userId = \Auth::User()->slack;
            $token = config('services.slack.token');
        }

        if(isset($token) && isset($userId)) {
            $data = [
                'token' => $token,
                'user' => $userId,
            ];
            $url = 'https://slack.com/api/users.info?' . http_build_query($data);
            $response = \Curl::get($url);
            $response['body'] = json_decode($response['body'], true);
            if ($response['body']['ok']) {
                $userData = $response['body']['user'];
                $user = new \Laravel\Socialite\Two\User();
                $user->id = $userData['id'];
                $user->nickname = $userData['name'];
                $user->name = $userData['real_name'];
                $user->email = $userData['profile']['email'];
                $user->avatar = $userData['profile']['image_192'];
                return $this->handleOauthUser($request, 'slack', $user);
            }
        }
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
        if (\Auth::check()) {
            \Auth::User()->saveOauthId($provider, $oAuthUser->getId());
            return redirect('app/profile/edit/'.\Auth::User()->id);
        } else {
            $user = User::$provider($oAuthUser->getId())->first();
            if (is_null($user)) {
                $user = User::email($oAuthUser->getEmail())->first();
                if (!is_null($user)) {
                    $user->saveOauthId($provider, $oAuthUser->getId());
                }
            }
            if (is_null($user)) {
                $user = User::create([
                    $provider => $oAuthUser->getId(),
                    'username' => is_null($oAuthUser->getNickname()) ? $oAuthUser->getName() : $oAuthUser->getNickname(),
                    'email' => $oAuthUser->getEmail(),
                ]);
                event(new UserCreated($user));
            }

            \Auth::login($user);
            return $this->handleUserWasAuthenticated($request, $this->isUsingThrottlesLoginsTrait());
        }
    }
}
