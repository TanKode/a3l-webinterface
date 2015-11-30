<?php namespace A3LWebInterface\Http\Controllers\Auth;

use A3LWebInterface\Http\Controllers\Controller;
use A3LWebInterface\User;
use Illuminate\Support\Facades\Redirect;
use Invisnik\LaravelSteamAuth\SteamAuth;

class SteamController extends Controller
{

    /**
     * @var SteamAuth
     */
    private $steam;

    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    public function getLogin()
    {
        if ($this->steam->validate()) {
            return redirect(url('auth/register'))->with('player_id', $this->steam->getSteamId());
        } else {
            return $this->steam->redirect();
        }
    }
}