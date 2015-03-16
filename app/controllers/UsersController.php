<?php

class UsersController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), User::$rules);

        if($validator->passes()) {
            $user = new User;
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            return Redirect::to('/')->with('message', 'Vielen Dank für deine Registrierung! Du kannst dich nun anmelden.');
        } else {
            return Redirect::to('/')->with('message', 'Leider sind bei deiner Registrierung fehler aufgetreten. Versuche es doch noch einmal.')->withErrors($validator)->withInput();
        }
    }

    public function postSignin() {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            return Redirect::to('/')->with('message', 'Du bist angemeldet!');
        } else {
            return Redirect::to('/')
                ->with('message', 'Die E-Mail oder das Passwort waren falsch.')
                ->withInput();
        }
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('/')->with('message', 'Du wurdest erfolgreich abgemeldet!');
    }

    public function getSawn($movieid) {
        if(Auth::check()) {
            DB::table('u2m_sawn')->insert(
                array('userid' => Auth::user()->id, 'movieid' => $movieid)
            );

            return Redirect::to('/')->with('message', 'Änderung erfolgreich übernommen!');
        } else {
            return Redirect::to('/')->with('message', 'Du musst angemeldet sein um dies tun zu können!');
        }
    }

    public function getUnsawn($movieid) {
        if(Auth::check()) {
            DB::table('u2m_sawn')
                ->where('userid', '=', Auth::user()->id)
                ->where('movieid', '=', $movieid)
                ->delete();

            return Redirect::to('/')->with('message', 'Änderung erfolgreich übernommen!');
        } else {
            return Redirect::to('/')->with('message', 'Du musst angemeldet sein um dies tun zu können!');
        }
    }

    public function postSawn() {
        if(Auth::check()) {
            $rules = array(
                'staffel'=>'required|integer',
                'episode'=>'required|integer',
                'movieid'=>'required|integer'
            );

            $validator = Validator::make(Input::all(), $rules);

            if($validator->passes()) {
                $data = array(
                    'staffel' => Input::get('staffel'),
                    'episode' => Input::get('episode'),
                    'movieid' => Input::get('movieid'),
                    'userid' => Auth::user()->id
                );

                if($data['staffel'] == 0 && $data['episode'] == 0) {
                    $u2s_sawn = DB::table('u2s_sawn')
                        ->where('userid', '=', $data['userid'])
                        ->where('movieid', '=', $data['movieid'])
                        ->delete();
                } else {
                    $u2s_sawn = DB::table('u2s_sawn')
                        ->where('userid', '=', $data['userid'])
                        ->where('movieid', '=', $data['movieid'])
                        ->first();

                    if(!empty($u2s_sawn)) {
                        DB::table('u2s_sawn')
                            ->where('userid', $data['userid'])
                            ->where('movieid', $data['movieid'])
                            ->update(array('staffel' => $data['staffel'], 'episode' => $data['episode']));
                    } else {
                        DB::table('u2s_sawn')->insert(
                            array('userid' => $data['userid'], 'movieid' => $data['movieid'], 'staffel' => $data['staffel'], 'episode' => $data['episode'])
                        );
                    }
                }

                return Redirect::to(Input::get('ressource'))->with('message', 'Änderung erfolgreich übernommen!');
            } else {
                return Redirect::to(Input::get('ressource'))->with('message', 'Leider ist ein Fehler aufgetreten. Versuche es doch noch einmal!');
            }
        } else {
            return Redirect::to('/')->with('message', 'Du musst angemeldet sein um dies tun zu können!');
        }
    }



    public function getFavorite($movieid) {
        if(Auth::check()) {
            DB::table('u2ms_favos')->insert(
                array('userid' => Auth::user()->id, 'movieid' => $movieid)
            );

            return Redirect::to('/')->with('message', 'Änderung erfolgreich übernommen!');
        } else {
            return Redirect::to('/')->with('message', 'Du musst angemeldet sein um dies tun zu können!');
        }
    }

    public function getUnfavorite($movieid) {
        if(Auth::check()) {
            DB::table('u2ms_favos')
                ->where('userid', '=', Auth::user()->id)
                ->where('movieid', '=', $movieid)
                ->delete();

            return Redirect::to('/')->with('message', 'Änderung erfolgreich übernommen!');
        } else {
            return Redirect::to('/')->with('message', 'Du musst angemeldet sein um dies tun zu können!');
        }
    }
}