<?php
namespace App\Libs;

class Twemoji
{
    public static function d($code)
    {
        return self::display($code);
    }
    public static function c($code)
    {
        return self::clickable($code);
    }

    public static function display($code)
    {
        return self::create($code, false);
    }

    public static function clickable($code)
    {
        return self::create($code, true);
    }

    public static function create($code, $clickable = false)
    {
        $type = trim(strtolower($code));
        return '<img draggable="false" class="twemoji '.($clickable?'clickable':'').'" data-alt="'.$type.'" src="'.asset('svg/'.$type.'.svg').'" />';
    }
}