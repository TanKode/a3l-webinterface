<?php

return [

    /*
     * Redirect url after login
     */
    'redirect_url' => 'auth/steamcallback',
    /*
     *  Api Key (http://steamcommunity.com/dev/apikey)
     */
    'api_key' => env('STEAM_CLIENT_ID', ''),

];
