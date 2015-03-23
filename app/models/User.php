<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $rules = array(
		'playerid'=>'required|numeric|unique:users',
        'username'=>'required|alpha_num|min:2|max:32|unique:users',
		'email'=>'required|email|unique:users',
		'password'=>'required|min:6|confirmed',
		'password_confirmation'=>'required|min:6'
	);

    public function getAvatar( $email, $s = 64, $img = false, $atts = array(), $r = 'g', $d = 'monsterid' ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    public function decodeDBArray( $string ) {
        if(!empty($string)):
            $string = str_replace('"', '', $string);
            $string = str_replace('`', '"', $string);
            $array = json_decode($string);
            return $array;
        else:
            return [];
        endif;
    }

    public function encodeDBArray( $array, $ints = false ) {
        if(is_array($array)):
            $string = json_encode($array);
            $string = str_replace('{', '[', $string);
            $string = str_replace('"', '`', $string);
            $string = str_replace(':', ',', $string);
            $string = str_replace('}', ']', $string);
            if($ints == false) {
                $string = preg_replace("/`\d+`,/", "", $string);
            }
            $string = '"' . $string . '"';
            return $string;
        else:
            return null;
        endif;
    }

    public function canEditUser( $newLevel, $oldLevel ) {
        if(Auth::user()->level >= 4 && $newLevel <= Auth::user()->level && $oldLevel <= Auth::user()->level) {
            return true;
        } else {
            return false;
        }
    }

    public function canEditVehicle( $playerid ) {
        if(Auth::user()->level >= 2 && $playerid != Auth::user()->playerid) {
            return true;
        } else {
            return false;
        }
    }

    public function canEditPlayerLevel( $playerid ) {
        if(Auth::user()->level >= 1 && $playerid != Auth::user()->playerid) {
            return true;
        } else {
            return false;
        }
    }

    public function canEditPlayerLicenses( $playerid ) {
        if(Auth::user()->level >= 2 && $playerid != Auth::user()->playerid) {
            return true;
        } else {
            return false;
        }
    }

    public function canEditPlayerMoney( $playerid ) {
        if(Auth::user()->level >= 3 && $playerid != Auth::user()->playerid) {
            return true;
        } else {
            return false;
        }
    }

    public function canEditPlayerAdmin( $playerid ) {
        if(Auth::user()->level >= 4 && $playerid != Auth::user()->playerid) {
            return true;
        } else {
            return false;
        }
    }
}
