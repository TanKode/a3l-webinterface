<?php
namespace App\Libs;

class Formatter
{
    public static function decodeDBArray($string)
    {
        $return = array();
        if (!empty($string)):
            $string = str_replace('"', '', $string);
            $string = str_replace('`', '"', $string);
            $return = json_decode($string);
        endif;
        return $return;
    }

    public static function encodeDBArray($array, $ints = false)
    {
        $array = collect($array)->map(function ($bool, $license) {
            return [$license, $bool];
        })->toArray();
        sort($array);
        $return = null;
        if (is_array($array)):
            $string = json_encode($array);
            $string = str_replace('{', '[', $string);
            $string = str_replace('"', '`', $string);
            $string = str_replace(':', ',', $string);
            $string = str_replace('}', ']', $string);
            if ($ints == false) {
                $string = preg_replace("/`(\d+)`/", "$1", $string);
            }
            $return = '"' . $string . '"';
        endif;
        return $return;
    }

    public static function money($number)
    {
        return number_format($number, config('a3lwebinterface.formatter.decimals', 0), config('a3lwebinterface.formatter.decimal_seperator', ','), config('a3lwebinterface.formatter.thousand_seperator', '.')) . ' ' . config('a3lwebinterface.formatter.currency', '€');
    }
}