<?php

namespace App\Commands;

use App\Core\Contracts\Command;
use Exception;
use PDO;

class RunMigration implements Command
{
    private static $instance;
    private static $option_name = "Run migration";

    /**
     * Get the instance of the class
     *
     * @return static
     */
    public static function instance(): static
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Get the option name
     *
     * @return string
     */
    public function getOptionName(): string
    {
        return self::$option_name;
    }

    /**
     * Handle the command
     *
     * @return void
     */
    public function handle(): void
    {
        if (config('database') != 'mysql') {
            echo PHP_EOL . 'Error: Set the database value from /src/Configs/app.php to mysql to run migration' . PHP_EOL;
            exit;
        }

        $dbname = config('db_name');
        try {
            $this->createDatabase($dbname);
            $this->createUsersTable($dbname);
            $this->createEventsTable($dbname);
            $this->createAttendeesTable($dbname);

            echo PHP_EOL . 'Migration has been completed!' . PHP_EOL;
        } catch (Exception $e) {
            echo PHP_EOL . 'Error: ' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Create the database
     *
     * @param string $dbname
     * @return void
     */
    private function createDatabase(string $dbname): void
    {
        $db = new PDO("mysql:host=" . config('db_host'), config('db_username'), config('db_password'));
        $sql = "CREATE DATABASE $dbname";
        $db->exec($sql);
    }

    /**
     * Create users table
     *
     * @param string $dbname
     * @return void
     */
    private function createUsersTable(string $dbname): void
    {
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "CREATE TABLE users (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `first_name` VARCHAR(255) NOT NULL,
            `last_name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $db->exec($sql);
    }

    /**
     * Create events table
     *
     * @param string $dbname
     * @return void
     */
    private function createEventsTable(string $dbname): void
    {
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "CREATE TABLE events (
            `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `date` DATE NOT NULL,
            `time` VARCHAR(255) NOT NULL,
            `location` VARCHAR(255) NOT NULL,
            `attendees_count` INT UNSIGNED DEFAULT 0,
            `capacity` INT UNSIGNED NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";
        $db->exec($sql);
    }

    /**
     * Create attendees table
     *
     * @param string $dbname
     * @return void
     */
    private function createAttendeesTable(string $dbname): void
    {
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "CREATE TABLE attendees (
            `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `event_id` INT UNSIGNED NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
        )";
        $db->exec($sql);
    }
}
