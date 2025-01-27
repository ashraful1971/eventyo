<?php

// auto loader
require_once 'vendor/autoload.php';

// required files
require_once 'src/Constants/app.php';
require_once 'src/Libs/functions.php';

use App\Commands\RunMigration;
use App\Commands\RunSeeder;
use App\Core\Console;

$providers = config('providers');

// register options
Console::addOption(RunMigration::instance());
Console::addOption(RunSeeder::instance());

// run app
Console::run($providers);

