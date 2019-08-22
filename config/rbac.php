<?php

return [

    /*
    |--------------------------------------------------------------------------
    | main site roles
    |--------------------------------------------------------------------------
    |
    | default roles for main site
    |
    */

    'roles' => [
        'owner' => [
            'id' => 1,
            'role_name' => 'Owner',
            'role_description' => 'Administrator',
            'right' => 511,
        ],
        'member' => [
            'id' => 2,
            'role_name' => 'Member',
            'role_description' => 'General user',
            'right' => 128,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | sub site roles
    |--------------------------------------------------------------------------
    |
    | default roles for sub sites
    |
    */

    'sub_site_roles' => [
        'owner' => [
            'role_name' => 'Owner',
            'role_description' => 'Administrator',
            'right' => 0,
        ],
        'member' => [
            'role_name' => 'Member',
            'role_description' => 'General user',
            'right' => 0,
        ],
    ],

     /*
    |--------------------------------------------------------------------------
    | rights
    |--------------------------------------------------------------------------
    |
    | max rights items is 63
    | max item value: 4611686018427387904
    | max sum value: 9223372036854775807
    |
    | all         list all
    | self        list items belong to user
    | edit        create,edit,update,delete
    |
    */

    'rights' => [
        'user' => [
            "all" => 1,
            "edit" => 2,
        ],
        'role' => [
            "all" => 4,
            "edit" => 8,
        ],
        'right' => [
            "all" => 16,
            "edit" => 32,
        ],
        'site' => [
            "all" => 64,
            "self" => 128,
            "edit" => 256,
        ],
    ],
];
