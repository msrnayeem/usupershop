<?php

return [
    'default' => env('COURIER_DEFAULT', 'steadfast'),
    'logging' => env('COURIER_LOGGING', true),

    'steadfast' => [
        'enabled' => env('STEADFAST_ENABLED', true),
        'base_url' => env('STEADFAST_BASE_URL', 'https://portal.packzy.com/api/v1'),
        'api_key' => env('STEADFAST_API_KEY'),
        'secret_key' => env('STEADFAST_SECRET_KEY'),
    ],

    'pathao' => [
        'enabled' => env('PATHAO_ENABLED', true),
        'base_url' => env('PATHAO_BASE_URL', 'https://courier-api-sandbox.pathao.com'),
        'client_id' => env('PATHAO_CLIENT_ID'),
        'client_secret' => env('PATHAO_CLIENT_SECRET'),
        'username' => env('PATHAO_USERNAME'),
        'password' => env('PATHAO_PASSWORD'),
        'store_id' => env('PATHAO_STORE_ID', 1),
    ],
];