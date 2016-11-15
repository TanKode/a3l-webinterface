<?php
namespace App\Libs;

class Helper
{
    public function transd($key, $default = null)
    {
        if (\Lang::has($key)) {
            return \Lang::trans($key);
        } else {
            return $default;
        }
    }

    public function getContrastColor($color)
    {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));

        return ($r + $g + $b > 382) ? '#000000' : '#ffffff';
    }

    public function aurl($path)
    {
        return config('app.url') . '/' . trim($path, '/');
    }
}