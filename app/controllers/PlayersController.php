<?php

class PlayersController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function postEdit() {
        $rules = array(
            'uid'=>'required|numeric|exists:players,uid',
            'playerid'=>'required|numeric|exists:players,playerid',
            'cash'=>'numeric',
            'bankacc'=>'numeric',
            'coplevel'=>'numeric|min:0|max:11',
            'mediclevel'=>'numeric|min:0|max:5',
            'adaclevel'=>'numeric|min:0|max:5',
            'donatorlvl'=>'numeric|min:0|max:5',
            'adminlevel'=>'numeric|min:0|max:3'
        );

        $validator = Validator::make(Input::all(), $rules);

        $civ_licenses = array(
            array('license_civ_sec', 0),
            array('license_civ_donator', 0),
            array('license_civ_home', 0),
            array('license_civ_rebel', 0),
            array('license_civ_bm', 0),
            array('license_civ_gun', 0),
            array('license_civ_driver', 0),
            array('license_civ_truck', 0),
            array('license_civ_air', 0),
            array('license_civ_boat', 0),
            array('license_civ_dive', 0),
            array('license_civ_heroin', 0),
            array('license_civ_coke', 0),
            array('license_civ_marijuana', 0),
            array('license_civ_oil', 0),
            array('license_civ_diamond', 0),
            array('license_civ_copper', 0),
            array('license_civ_iron', 0),
            array('license_civ_sand', 0),
            array('license_civ_salt', 0),
            array('license_civ_cement', 0),
            array('license_civ_brauer', 0),
            array('license_civ_wein', 0),
            array('license_civ_zigaretten', 0),
            array('license_civ_zucker', 0),
            array('license_civ_whiskey', 0),
            array('license_civ_zigarren', 0),
            array('license_civ_rum', 0),
            array('license_civ_holz', 0),
            array('license_civ_schwefel', 0),
            array('license_civ_silber', 0),
            array('license_civ_zinn', 0),
            array('license_civ_gusseisen', 0),
            array('license_civ_bronze', 0),
            array('license_civ_schmuck', 0),
            array('license_civ_good', 0),
            array('license_civ_bus', 0),
            array('license_civ_taxi', 0),
            array('license_civ_hunting', 0),
        );

        $cop_licenses = array(
            array('license_cop_air', 0),
            array('license_cop_sek', 0),
            array('license_cop_cg', 0),
        );

        $med_licenses = array(
            array('license_med_air', 0),
        );

        $adac_licenses = array(
            array('license_adac_car', 0),
            array('license_adac_air', 0),
        );

        if($validator->passes() && Auth::user()->canEditPlayerAdmin(Input::get('playerid'))) {
            foreach(Input::all() as $str_key => $value):
                $subStr = substr($str_key, 0, 12);
                if($subStr == 'license_civ_'):
                    foreach($civ_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $civ_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_cop_'):
                    foreach($cop_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $cop_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_med_'):
                    foreach($med_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $med_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_adac'):
                    foreach($adac_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $adac_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
            endforeach;

            $civ_licenses = Auth::user()->encodeDBArray($civ_licenses);
            $cop_licenses = Auth::user()->encodeDBArray($cop_licenses);
            $med_licenses = Auth::user()->encodeDBArray($med_licenses);
            $adac_licenses = Auth::user()->encodeDBArray($adac_licenses);

            $player = Player::find(Input::get('uid'));
            $player->cash = Input::get('cash');
            $player->bankacc = Input::get('bankacc');
            $player->coplevel = Input::get('coplevel');
            $player->mediclevel = Input::get('mediclevel');
            $player->adaclevel = Input::get('adaclevel');
            $player->civ_licenses = $civ_licenses;
            $player->cop_licenses = $cop_licenses;
            $player->med_licenses = $med_licenses;
            $player->adac_licenses = $adac_licenses;
            $player->donatorlvl = Input::get('donatorlvl');
            $player->adminlevel = Input::get('adminlevel');
            $player->save();

            return Redirect::to('/players')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } elseif($validator->passes() && Auth::user()->canEditPlayerMoney(Input::get('playerid'))) {
            foreach(Input::all() as $str_key => $value):
                $subStr = substr($str_key, 0, 12);
                if($subStr == 'license_civ_'):
                    foreach($civ_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $civ_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_cop_'):
                    foreach($cop_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $cop_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_med_'):
                    foreach($med_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $med_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_adac'):
                    foreach($adac_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $adac_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
            endforeach;

            $civ_licenses = Auth::user()->encodeDBArray($civ_licenses);
            $cop_licenses = Auth::user()->encodeDBArray($cop_licenses);
            $med_licenses = Auth::user()->encodeDBArray($med_licenses);
            $adac_licenses = Auth::user()->encodeDBArray($adac_licenses);

            $player = Player::find(Input::get('uid'));
            $player->cash = Input::get('cash');
            $player->bankacc = Input::get('bankacc');
            $player->coplevel = Input::get('coplevel');
            $player->mediclevel = Input::get('mediclevel');
            $player->adaclevel = Input::get('adaclevel');
            $player->civ_licenses = $civ_licenses;
            $player->cop_licenses = $cop_licenses;
            $player->med_licenses = $med_licenses;
            $player->adac_licenses = $adac_licenses;
            $player->donatorlvl = Input::get('donatorlvl');
            $player->save();

            return Redirect::to('/players')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } elseif($validator->passes() && Auth::user()->canEditPlayerLicenses(Input::get('playerid'))) {
            foreach(Input::all() as $str_key => $value):
                $subStr = substr($str_key, 0, 12);
                if($subStr == 'license_civ_'):
                    foreach($civ_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $civ_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_cop_'):
                    foreach($cop_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $cop_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_med_'):
                    foreach($med_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $med_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
                if($subStr == 'license_adac_'):
                    foreach($adac_licenses as $int_key => $array):
                        if($array[0] == $str_key):
                            $adac_licenses[$int_key][1] = $value * 1;
                        endif;
                    endforeach;
                endif;
            endforeach;

            $civ_licenses = Auth::user()->encodeDBArray($civ_licenses);
            $cop_licenses = Auth::user()->encodeDBArray($cop_licenses);
            $med_licenses = Auth::user()->encodeDBArray($med_licenses);
            $adac_licenses = Auth::user()->encodeDBArray($adac_licenses);

            $player = Player::find(Input::get('uid'));
            $player->cash = Input::get('cash');
            $player->bankacc = Input::get('bankacc');
            $player->coplevel = Input::get('coplevel');
            $player->mediclevel = Input::get('mediclevel');
            $player->adaclevel = Input::get('adaclevel');
            $player->civ_licenses = $civ_licenses;
            $player->cop_licenses = $cop_licenses;
            $player->med_licenses = $med_licenses;
            $player->adac_licenses = $adac_licenses;
            $player->save();

            return Redirect::to('/players')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } elseif($validator->passes() && Auth::user()->canEditPlayerLevel(Input::get('playerid'))) {
            $player = Player::find(Input::get('playerid'));
            $player->coplevel = Input::get('coplevel');
            $player->mediclevel = Input::get('mediclevel');
            $player->adaclevel = Input::get('adaclevel');
            $player->save();

            return Redirect::to('/players')
                ->with(array('message'=>'Die Änderung wurde erfolgreich übernommen.', 'type' => 'success'));
        } else {
            return Redirect::to('/players')
                ->with(array('message'=>'Leider ist ein Fehler aufgetreten, die Änderung wurde verworfen.', 'type' => 'danger'));
        }
    }
}