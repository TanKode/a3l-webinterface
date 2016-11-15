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

if (!function_exists('array_diff_recursive')) {
    function array_diff_recursive($arr1, $arr2)
    {
        $outputDiff = [];

        foreach ($arr1 as $key => $value) {
            if (array_key_exists($key, $arr2)) {
                if (is_array($value)) {
                    $recursiveDiff = array_diff_recursive($value, $arr2[$key]);

                    if (count($recursiveDiff)) {
                        $outputDiff[$key] = $recursiveDiff;
                    }
                } else if (!in_array($value, $arr2)) {
                    $outputDiff[$key] = $value;
                }
            } else if (!in_array($value, $arr2)) {
                $outputDiff[$key] = $value;
            }
        }

        return $outputDiff;
    }
}