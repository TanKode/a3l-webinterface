<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'teamspeak' => [
        'user' => env('TS3_USER', 'serveradmin'),
        'password' => env('TS3_PASSWORD', ''),
        'host' => env('TS3_HOST', ''),
        'port' => env('TS3_PORT', 10011),
        'server_port' => env('TS3_SERVER_PORT', 9987),
    ],

    // oAuth
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', ''),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', ''),
        'redirect' => 'http://bambusfarm.net/auth/facebookcallback',
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID', ''),
        'client_secret' => env('GITHUB_CLIENT_SECRET', ''),
        'redirect' => 'http://bambusfarm.net/auth/githubcallback',
    ],

    'slack' => [
        'client_id' => env('SLACK_CLIENT_ID', ''),
        'client_secret' => env('SLACK_CLIENT_SECRET', ''),
        'token' => env('SLACK_TOKEN', ''),
        'redirect' => 'http://bambusfarm.net/auth/slackcallback',
    ],

];
