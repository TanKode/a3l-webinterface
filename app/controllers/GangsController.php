<?php

class GangsController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postEdit() {
        $rules = array(
            'gangid'=>'required|numeric|exists:gangs,id',
            'newmember'=>'numeric',
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

            if(Input::get('newmember')) {
                array_push($members, Input::get('newmember'));
            }

            $members = Auth::user()->encodeDBArray($members, true);

            $active = 0;
            if(Input::get('active') == 1)
                $active = 1;


            $gang = Gang::find(Input::get('gangid'));

            $log = new Adminlog;
            $log->type = 'gang';
            $log->editor = Auth::user()->id;
            $log->objectid = Input::get('gangid');
            $log->difference = $log->getDifference(
                array('members'=>$gang->members, 'maxmembers'=>$gang->maxmembers, 'bank'=>$gang->bank, 'active'=>$gang->active),
                array('members'=>$members, 'maxmembers'=>Input::get('maxmembers')*1, 'bank'=>Input::get('bank')*1, 'active'=>$active)
            );
            $log->save();

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