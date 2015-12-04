<?php
if (!function_exists('transd')) {
    function transd($key, $default = null)
    {
        return \App\Libs\Helper::transd($key, $default);
    }
}