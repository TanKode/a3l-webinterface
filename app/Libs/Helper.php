<?php
namespace App\Libs;

class Helper
{
    public static function transd($key, $default = null)
    {
        if (\Lang::has($key)) {
            return \Lang::trans($key);
        } else {
            return $default;
        }
    }
}