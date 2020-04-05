<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | The router prefix
    |--------------------------------------------------------------------------
    |
    | This will be the prefix for the `/csrf-header` GET route.
    | E.g. prefix = 'api' => than you can get the header token via: `/api/csrf-header
    |
    */

    'prefix' => env('STATELESS_PREFIX', 'api'),

    /*
    |--------------------------------------------------------------------------
    | Header Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the header used to identify a session
    | instance by ID. The name specified here will get used every time a
    | new session cookie is created by the framework for every driver.
    |
    */

    'header' => env(
        'STATELESS_SESSION_HEADER',
        Str::upper(Str::slug(env('APP_NAME', 'laravel'), '-') . '-session')
    ),

];
