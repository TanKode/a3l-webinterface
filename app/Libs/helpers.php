<?php
if (!function_exists('transd')) {
    function transd($key, $default = null)
    {
        return \Helper::transd($key, $default);
    }
}