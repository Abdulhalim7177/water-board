<?php

return [
    'defaults' => [
        'guard' => 'customer',
        'passwords' => 'customers',
    ],

    'guards' => [
        'customer' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],
        'customer-api' => [
            'driver' => 'sanctum',
            'provider' => 'customers',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];