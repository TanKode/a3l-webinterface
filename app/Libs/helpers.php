<?php
if (!function_exists('transd')) {
    function transd($key, $default = null)
    {
        return \Helper::transd($key, $default);
    }
}

if (!function_exists('aurl')) {
    function aurl($path)
    {
        return \Helper::aurl($path);
    }
}