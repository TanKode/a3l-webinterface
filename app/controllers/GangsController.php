<?php

class GangsController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postEdit() {
        $rules = array(
            'gangid'=>'required|numeric|exists:gangs,id',
            'maxmembers'=>'numeric',
            'bank'=>'numeric',
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->passes() && Auth::user()->level >= 2) {
            $members = array();
            foreach(Input::all() as $key => $value):
//                $key = str_replace('member_', '', $key);
                if($key != 'bank' && $key != '_token' && $key != 'gangid' && $key != 'active' && $key != 'maxmembers'):
                    $key = str_replace('member_', '', $key);
                    array_push($members, $key);
                endif;
            endforeach;

            $members = Auth::user()->encodeDBArray($members, true);

            $active = 0;
            if(Input::get('active') == 1)
                $active = 1;


            $gang = Gang::find(Input::get('gangid'));
            $gang->members = $members;
            $gang->maxmembers = Input::get('maxmembers');

            if(Auth::user()->level >= 3) {
                $gang->bank = Input::get('bank');
                $gang->active = $active;
            }
            $gang->save();

            return Redirect::to('/gangs')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } else {
            return Redirect::to('/gangs')
                ->with(array('message'=>'Leider ist ein Fehler aufgetreten, die Änderung wurde verworfen.', 'type' => 'danger'));
        }
    }
}