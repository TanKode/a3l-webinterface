<?php

class DonatorsController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postEdit() {
        $rules = array(
            'uid'=>'required|numeric|exists:players,uid',
            'playerid'=>'required|numeric|exists:players,playerid',
            'donatorlvl'=>'numeric|min:0|max:5',
            'reason'=>'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes() && Auth::user()->canEditPlayerAdmin(Input::get('playerid'))) {
            $player = Player::find(Input::get('uid'));

            $log = new Adminlog;
            $log->type = 'player';
            $log->editor = Auth::user()->id;
            $log->objectid = Input::get('uid');
            $log->reason = Input::get('reason');
            $log->difference = $log->getDifference(
                array(
                    'donatorlvl'=>$player->donatorlvl,
                    'donatordate'=>$player->donatordate,
                    'donatoramount'=>$player->donatoramount,
                    'donatorduration'=>$player->donatorduration,
                ),
                array(
                    'donatorlvl'=>Input::get('donatorlvl'),
                    'donatordate'=>Input::get('donatordate'),
                    'donatoramount'=>Input::get('donatoramount') * 1,
                    'donatorduration'=>Input::get('donatorduration'),
                )
            );
            $log->save();

            $player->donatorlvl = Input::get('donatorlvl');
            $player->donatordate = Input::get('donatordate');
            $player->donatoramount = Input::get('donatoramount') * 1;
            $player->donatorduration = Input::get('donatorduration');
            $player->save();

            return Redirect::to('/donators')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } else {
            return Redirect::to('/donators')
                ->with(array('message'=>'Leider ist ein Fehler aufgetreten, die Änderung wurde verworfen.', 'type' => 'danger'));
        }
    }

    public function postAdd() {
        $rules = array(
            'playerid'=>'required|numeric|exists:players,playerid',
            'donatoramount'=>'numeric|required',
            'donatorduration'=>'numeric|required',
            'donatordate'=>'required',
            'reason'=>'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes() && Auth::user()->canEditPlayerAdmin(Input::get('playerid'))) {
            $player = Player::where('playerid', Input::get('playerid'))->first();

            $log = new Adminlog;
            $log->type = 'player';
            $log->editor = Auth::user()->id;
            $log->objectid = $player->uid;
            $log->reason = Input::get('reason');
            $log->difference = $log->getDifference(
                array(
                    'donatorlvl'=>$player->donatorlvl,
                    'donatordate'=>$player->donatordate,
                    'donatoramount'=>$player->donatoramount,
                    'donatorduration'=>$player->donatorduration,
                ),
                array(
                    'donatorlvl'=>5,
                    'donatordate'=>Input::get('donatordate'),
                    'donatoramount'=>Input::get('donatoramount') * 1,
                    'donatorduration'=>Input::get('donatorduration'),
                )
            );
            $log->save();

            $player->donatorlvl = Input::get('donatorlvl');
            $player->donatordate = Input::get('donatordate');
            $player->donatoramount = Input::get('donatoramount') * 1;
            $player->donatorduration = Input::get('donatorduration');
            $player->save();

            return Redirect::to('/donators')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } else {
            return Redirect::to('/donators')
                ->with(array('message'=>'Leider ist ein Fehler aufgetreten, die Änderung wurde verworfen.', 'type' => 'danger'));
        }
    }
}