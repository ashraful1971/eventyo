<?php

use App\Providers\AppServiceProvider;

return [
    'database' => 'mysql', // mysql

    'providers' => [
        AppServiceProvider::class
    ], // all the providers will be listed here

    'db_host' => 'localhost',
    'db_name' => 'event',
    'db_username' => 'root',
    'db_password' => '',
];