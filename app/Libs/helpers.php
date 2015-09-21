<?php
if(!function_exists('json_print')) {
    function json_print($value) {
        echo json_encode($value, JSON_PRETTY_PRINT);
    }
}

if(!function_exists('storage_get')) {
    function storage_get($file) {
        $path = storage_path('app/'.$file);
        if(file_exists($path)) {
            return file_get_contents($path);
        } else {
            return '';
        }
    }
}