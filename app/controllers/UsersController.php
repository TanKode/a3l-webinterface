<?php

class UsersController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postCreate() {
        $messages = array(
            'playerid.required' => 'Deine Spieler-ID wird benötigt.',
            'playerid.numeric' => 'Die Spieler-ID besteht nur aus Zahlen.',
            'playerid.min' => 'Die Spieler-ID ist 17 Ziffern lang.',
            'playerid.unique' => 'Die Spieler-ID wurde schon beansprucht - falls dies deine ist melde dich bei einem Supporter.',
            'username.required' => 'Dein Nutzername wird benötigt.',
            'username.alpha_num' => 'Dein Nutzername darf nur aus Zahlen und Buchstaben bestehen.',
            'username.unique' => 'Der Nutzername ist schon vergeben - bitte such dir einen anderen.',
            'email.required' => 'Deine E-Mail wird benötigt.',
            'email.email' => 'Dies ist keine gültige E-Mail Adresse.',
            'email.unique' => 'Verwende bitte eine andere E-Mail Adresse.',
            'password.required' => 'Dein Passwort wird benötigt.',
            'password.min' => 'Dein Passwort muss min. 6 Zeichen lang sein.',
            'password.confirmed' => 'Deine Passwort-Wiederholung stimmt nicht überein.',
            'password_confirmation.required' => 'Wiederhole dein Passwort.',
        );

        $validator = Validator::make(Input::all(), User::$rules, $messages);

        if($validator->passes()) {
            $user = new User;
            $user->playerid = Input::get('playerid');
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            return Redirect::to('/login')
                ->with(array('message'=>'Vielen Dank für deine Registrierung! Du kannst dich nun anmelden.', 'type'=>'success'));
        } else {
            return Redirect::to('/register')
                ->with(array('message'=>'Leider sind bei deiner Registrierung Fehler aufgetreten. Versuche es doch noch einmal.', 'type' => 'danger'))
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function postLogin() {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            return Redirect::to('/')->with('message', 'Du bist angemeldet!');
        } else {
            return Redirect::to('/login')
                ->with('message', 'Die E-Mail oder das Passwort waren falsch.')
                ->withInput();
        }
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('/login')
            ->with(array('message'=>'Du wurdest erfolgreich abgemeldet.', 'type'=>'success'));
    }
}