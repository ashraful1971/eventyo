<?php

namespace App\Commands;

use App\Core\Contracts\Command;
use Exception;
use PDO;

class RunSeeder implements Command
{
    private static $instance;
    private static $option_name = "Run seeder";

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
            $this->createUsers($dbname);
            $this->createEvents($dbname);

            echo PHP_EOL . 'Seeding has been completed!' . PHP_EOL;
        } catch (Exception $e) {
            echo PHP_EOL . 'Error: ' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Create users
     *
     * @param string $dbname
     * @return void
     */
    private function createUsers(string $dbname): void
    {
        $password = password_hash("123456", PASSWORD_DEFAULT);
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $sql = "INSERT INTO users (`first_name`, `last_name`, `email`, `password`) VALUES
            ('John', 'Doe', 'john@gmail.com', '$password'),
            ('Jane', 'Doe', 'jane@gmail.com', '$password')";
        $db->exec($sql);
    }

    /**
     * Get the first user id
     *
     * @param string $dbname
     * @return int
     */
    private function getFirstUserId(string $dbname): int
    {
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $stmt = $db->prepare("SELECT id FROM users ORDER BY id ASC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Create events
     *
     * @param string $dbname
     * @return void
     */
    private function createEvents(string $dbname): void
    {
        $desc = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
        $db = new PDO("mysql:host=" . config('db_host') . ";dbname=$dbname", config('db_username'), config('db_password'));
        $user_id = $this->getFirstUserId($dbname);

        $sql = "INSERT INTO events (`name`, `user_id`, `description`, `date`, `time`, `location`, `capacity`) VALUES
            ('Ollyo Conf', '$user_id', '$desc', '2025-10-10', '10:00 AM - 03:30 PM', 'Dhaka, Banlgadesh', 100),
            ('Tech Summit', '$user_id', '$desc', '2025-10-15', '11:00 AM', 'Gazipur', 200),
            ('Startup Expo', '$user_id', '$desc', '2025-10-20', '09:00 AM - 05:00 PM', 'Rajshahi', 150),
            ('Webinar', '$user_id', '$desc', '2025-10-25', '02:00 PM', 'Khulna', 50),
            ('Music Fest', '$user_id', '$desc', '2025-10-30', '06:00 PM', 'Sylhet', 300),
            ('Food Fest', '$user_id', '$desc', '2025-11-05', '12:00 PM', 'Chittagong', 250),
            ('Art Expo', '$user_id', '$desc', '2025-01-10', '10:00 AM - 04:00 PM', 'Barishal', 100),
            ('Fashion Show', '$user_id', '$desc', '2025-01-15', '07:00 PM', 'Comilla', 200),
            ('Book Fair', '$user_id', '$desc', '2025-01-20', '09:00 AM - 08:00 PM', 'Rangpur', 150),
            ('Car Show', '$user_id', '$desc', '2025-01-25', '11:00 AM', 'Mymensingh', 50),
            ('Tech Expo', '$user_id', '$desc', '2025-01-30', '10:00 AM - 05:00 PM', 'Dhaka, Banlgadesh', 300),
            ('Health Expo', '$user_id', '$desc', '2025-12-05', '09:00 AM - 06:00 PM', 'Dhaka, Banlgadesh', 250),
            ('Job Fair', '$user_id', '$desc', '2025-12-10', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 100),
            ('Startup Expo 2025', '$user_id', '$desc', '2025-12-15', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 200),
            ('Webinar 2025', '$user_id', '$desc', '2025-12-20', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 150),
            ('Music Fest 2025', '$user_id', '$desc', '2025-12-25', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 50),
            ('Food Fest 2025', '$user_id', '$desc', '2025-12-30', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 300),
            ('Art Expo 2025', '$user_id', '$desc', '2025-02-05', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 250),
            ('Fashion Show 2025', '$user_id', '$desc', '2025-02-10', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 100),
            ('Book Fair 2025', '$user_id', '$desc', '2025-02-15', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 200),
            ('Car Show 2025', '$user_id', '$desc', '2025-02-20', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 150),
            ('Tech Expo 2025', '$user_id', '$desc', '2025-02-25', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 50),
            ('Health Expo 2025', '$user_id', '$desc', '2025-02-26', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 300),
            ('Job Fair 2025', '$user_id', '$desc', '2025-02-05', '10:00 AM - 04:00 PM', 'Dhaka, Banlgadesh', 250)";

        $db->exec($sql);
    }
}
