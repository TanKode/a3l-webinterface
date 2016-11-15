<?php
namespace App\Libs;

class Formatter
{
    public function decodeDBArray($string)
    {
        $return = [];
        if (!empty($string)) {
            $string = str_replace('"', '', $string);
            $json = str_replace('`', '"', $string);
            $return = json_decode($json);
            if (is_null($return)) {
                dump($string);
            }
        }
        return $return;
    }

    public function encodeDBArray($array, $ints = false)
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

    public function money($number)
    {
        return number_format($number, config('a3lwebinterface.formatter.decimals', 0), config('a3lwebinterface.formatter.decimal_seperator', ','), config('a3lwebinterface.formatter.thousand_seperator', '.')) . ' ' . config('a3lwebinterface.formatter.currency', '€');
    }

    public function getMBbyB($bytes)
    {
        return number_format($bytes / 1024 / 1024, 2, config('a3lwebinterface.formatter.decimal_seperator', ','), config('a3lwebinterface.formatter.thousand_seperator', '.'));
    }
}