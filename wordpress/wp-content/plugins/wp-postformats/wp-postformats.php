<?php
/*
Plugin Name: WP-Postformats
Description: Disables post-formats
Version: 1.0
Author: Tom Witkowski
*/

defined('ABSPATH') or die('Silence is golden.');

function disableUnwantedPostFormats()
{
    add_theme_support('post-formats', [
        'image',
        'quote',
        'status',
        'video',
    ]);
}

add_action('init', 'disableUnwantedPostFormats', 9999);