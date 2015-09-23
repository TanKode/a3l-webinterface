<?php
if (!function_exists('json_print')) {
    function json_print($value)
    {
        echo json_encode($value, JSON_PRETTY_PRINT);
    }
}

if (!function_exists('storage_get')) {
    function storage_get($file)
    {
        $path = storage_path('app/' . $file);
        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            return '';
        }
    }
}

if (!function_exists('format_float')) {
    function format_float($float)
    {
        return number_format($float, 2, ',', '.');
    }
}

if (!function_exists('format_money')) {
    function format_money($float)
    {
        return format_float($float) . ' €';
    }
}

if (!function_exists('full_ability_name')) {
    function full_ability_name($ability)
    {
        $fullName[] = $ability->name;
        $fullName[] = class_basename($ability->entity_type);
        $fullName[] = $ability->entity_id;

        return str_slug(implode(' ', array_filter($fullName)));
    }
}