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
            'role_description' => 'Administrator of main site',
            'right' => 255,
        ],
        'member' => [
            'id' => 2,
            'role_name' => 'Member',
            'role_description' => 'General user of main site',
            'right' => 128,
        ],
        'sub_owner' => [
            'id' => 3,
            'role_name' => 'Owner',
            'role_description' => 'Administrator of sub site',
            'right' => 0,
        ],
        'sub_member' => [
            'id' => 4,
            'role_name' => 'Member',
            'role_description' => 'General user of sub site',
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
        'site' => [
            "list" => 64,
            "update" => 128,
        ],
    ],
];
