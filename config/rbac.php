<?php

return [

    /*
    |--------------------------------------------------------------------------
    | roles
    |--------------------------------------------------------------------------
    |
    | 
    |
    */

    'roles' => [
        'owner' => [
            'id' => 1,
            'role_name' => 'Owner',
            'role_description' => 'Administrator',
            'right' => 63,
        ],
        'member' => [
            'id' => 2,
            'role_name' => 'Member',
            'role_description' => 'General user',
            'right' => 17,
        ],
        'guest' => [
            'id' => 3,
            'role_name' => 'Guest',
            'role_description' => 'Guest',
            'right' => 0,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | default role
    |--------------------------------------------------------------------------
    |
    | 
    |
    */

    'defaultRole' => 'member',

     /*
    |--------------------------------------------------------------------------
    | rights
    |--------------------------------------------------------------------------
    |
    | max rights items is 63
    | max item value: 4611686018427387904
    | max sum value: 9223372036854775807
    |
    | List        list
    | Update      create,update,delete
    |
    */

    'rights' => [
        'user' => [
            "list" => 1,
            "update" => 2,
        ],
        'role' => [
            "list" => 4,
            "update" => 8,
        ],
        'right' => [
            "list" => 16,
            "update" => 32,
        ],
    ],
];
