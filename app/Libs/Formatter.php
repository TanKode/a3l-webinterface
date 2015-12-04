<?php namespace App\Libs;

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
        $return = null;
        if (is_array($array)):
            $string = json_encode($array);
            $string = str_replace('{', '[', $string);
            $string = str_replace('"', '`', $string);
            $string = str_replace(':', ',', $string);
            $string = str_replace('}', ']', $string);
            if ($ints == false) {
                $string = preg_replace("/`\d+`,/", "", $string);
            }
            $return = '"' . $string . '"';
        endif;
        return $return;
    }

    public static function money($number)
    {
        return number_format($number, \Setting::get('formatter.decimals', 0), \Setting::get('formatter.decimal_seperator', ','), \Setting::get('formatter.thousand_seperator', '.')) . ' ' . trim(\Setting::get('formatter.currency', '€'));
    }

}