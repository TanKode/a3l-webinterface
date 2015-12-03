<?php
if (!function_exists('transd')) {
    function transd($key, $default = null)
    {
        return \A3LWebInterface\Libs\Helper::transd($key, $default);
    }
}