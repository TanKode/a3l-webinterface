<?php
namespace A3LWebInterface\Libs;

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