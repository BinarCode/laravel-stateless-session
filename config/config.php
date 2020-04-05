<?php

use Illuminate\Support\Str;

return [

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
        'SESSION_HEADER',
        Str::upper(Str::slug(env('APP_NAME', 'laravel'), '-').'-session')
    ),

];
