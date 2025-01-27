<?php

// auto loader
require_once 'vendor/autoload.php';

// required files
require_once 'src/Constants/app.php';
require_once 'src/Libs/functions.php';
require_once 'src/Routes/web.php';
require_once 'src/Routes/api.php';

//session start
session_start();

// service container
$container = container();

//providers
$providers = config('providers');

// run app
App\Core\Application::init($container)
    ->withRoutes(App\Core\Route::collection())
    ->withProviders($providers)
    ->run(App\Core\Request::create());

