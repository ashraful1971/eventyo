<?php

namespace App\Core;

use App\Core\Contracts\Command;

class Console
{

    private static $options = [];
    private static $providers = [];

    /**
     * Register all the service providers
     *
     * @return void
     */
    private static function registerProviders($providers): void
    {
        foreach($providers as $provider){
            $instance = container()->make($provider);
            $instance->register(container());
        }
    }

    /**
     * Add new command class
     * 
     * @param Command $command
     * @return void
     */
    public static function addOption(Command $command): void
    {
        self::$options[count(self::$options)+1] = $command;
    }

    /**
     * Run the application
     *
     * @return void
     */
    public static function run($providers): void
    {
        self::registerProviders($providers);

        $in_loop = true;

        while ($in_loop) {

            echo PHP_EOL;
            self::printAvailableOpions();

            echo PHP_EOL;
            $input = (int)readline('=> Enter your option: ');
            echo PHP_EOL;

            if($input == 0){
                $in_loop = false;
                break;
            }

            if(!isset(self::$options[$input])){
                echo 'Wrong number! Try again!' . PHP_EOL;
                continue;
            }

            self::$options[$input]->handle();
        }
    }

    /**
     * Print all available actions
     *
     * @return void
     */
    private static function printAvailableOpions(): void
    {
        echo "--- Available Actions ---" . PHP_EOL;
        foreach (self::$options as $key => $value) {
            if($key == 0){
                continue;
            }
            printf("[%d] %s \n", $key, $value->getOptionName());
        }

        printf("[0] Exit \n");
    }
}
