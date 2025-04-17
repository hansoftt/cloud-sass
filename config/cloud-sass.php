<?php

// config for Hansoft/CloudSass
return [
    'layout'      => 'layouts.app',

    'connections' => [
        'client' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '3306'),
            'database'  => '',
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => 'InnoDB',
        ],
    ],

    'migrations_location' => base_path('database/client-migrations'),
];
