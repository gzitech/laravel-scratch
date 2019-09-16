<?php

return [

    /*
    |--------------------------------------------------------------------------
    | main site domains
    |--------------------------------------------------------------------------
    |
    | 
    |
    */

    'domains' => [
        "dev.scratch",
        "scratch.fastconfirm.com"
    ],

    /*
    |--------------------------------------------------------------------------
    | sub site default domain
    |--------------------------------------------------------------------------
    |
    | the default domain for sub sites
    |
    */

    'default_domain' => env('SITE_DEFAULT_DOMAIN', 'fastconfirm.com'),
];
