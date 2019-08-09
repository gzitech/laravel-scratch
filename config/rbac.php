<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Role Id
    |--------------------------------------------------------------------------
    |
    | After user signup, assign user to the default role
    |
    */

    'default_role_id' => env('DEFAULT_ROLE_ID') ?? 2,

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
