<?php

namespace App\Core;

use App\Core\Contracts\DataStorage;
use App\Core\Enums\Operation;
use Exception;
use PDO;
use PDOException;

class DBStorage implements DataStorage
{

    private static $instance = null;
    private $connection;

    /**
     * Set the db file path and name
     */
    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Create and return the class instance
     *
     * @return self
     */
    public static function init(string $host, string $dbname, string $username, string $password): self
    {
        if (!self::$instance) {
            self::$instance = new self($host, $dbname, $username, $password);
        }

        return self::$instance;
    }

    /**
     * Get all the records
     *
     * @param string $table_name
     * @return array
     */
    public function all(string $table_name): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM $table_name");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Find a record
     *
     * @param string $table_name
     * @param string $coumn_name
     * @param mixed $value
     * @return array
     */
    public function find(string $table_name, string $column_name, mixed $value): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM $table_name WHERE $column_name = :value LIMIT 1");
            $stmt->bindValue(':value', $value);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetch();

            return $result ? $result : [];
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Find all records
     *
     * @param string $table_name
     * @param array $conditions
     * @param Operation $operation
     * @return array
     */
    public function findAll(string $table_name, array $conditions = [], Operation $operation = Operation::AND, int $offset = 0, int $limit = 0, string $order_by_column = 'id', $order_by_type = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . $table_name;
        if (count($conditions) > 0) {
            $query .= ' WHERE ';
            $whereClauses = [];
            foreach ($conditions as $condition) {
                $whereClauses[] = "$condition[0]  $condition[1]  :$condition[0]";
            }
            $query .= implode(" $operation->value ", $whereClauses);

            if ($order_by_column) {
                $query .= " ORDER BY $order_by_column $order_by_type";
            }

            if ($limit > 0) {
                $query .= " LIMIT $limit OFFSET $offset";
            }

            $stmt = $this->connection->prepare($query);

            foreach ($conditions as $condition) {
                if (strtoupper($condition[1]) == 'LIKE') {
                    $stmt->bindValue(":$condition[0]", "%$condition[2]%");
                } else {
                    $stmt->bindValue(":$condition[0]", $condition[2]);
                }
            }
        } else {
            if ($order_by_column) {
                $query .= " ORDER BY $order_by_column $order_by_type";
            }

            if ($limit > 0) {
                $query .= " LIMIT $limit OFFSET $offset";
            }

            $stmt = $this->connection->prepare($query);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll() ?? [];
    }

    /**
     * Find count of all records
     *
     * @param string $table_name
     * @param array $conditions
     * @param Operation $operation
     * @return int
     */
    public function findCount(string $table_name, array $conditions = [], Operation $operation = Operation::AND): int
    {
        $query = 'SELECT count(*) FROM ' . $table_name;

        if (count($conditions) > 0) {
            $query .= ' WHERE ';
            $whereClauses = [];

            foreach ($conditions as $condition) {
                $whereClauses[] = "$condition[0]  $condition[1]  :$condition[0]";
            }

            $query .= implode(" $operation->value ", $whereClauses);
            $stmt = $this->connection->prepare($query);

            foreach ($conditions as $condition) {
                if (strtoupper($condition[1]) == 'LIKE') {
                    $stmt->bindValue(":$condition[0]", "%$condition[2]%");
                } else {
                    $stmt->bindValue(":$condition[0]", $condition[2]);
                }
            }
        } else {
            $stmt = $this->connection->prepare($query);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchColumn() ?? 0;
    }

    /**
     * Create new record
     *
     * @param string $table_name
     * @param array $data
     * @return bool
     */
    public function create(string $table_name, array $data): bool
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update existing record
     *
     * @param string $table_name
     * @param array $data
     * @param mixed $id
     * @return bool
     */
    public function update(string $table_name, array $data, mixed $id): bool
    {
        try {
            if (isset($data['id'])) {
                unset($data['id']);
            }

            $set = [];

            foreach ($data as $key => $value) {
                $set[] = "$key = :$key";
            }

            $set_string = implode(', ', $set);

            $sql = "UPDATE $table_name SET $set_string WHERE id = :id";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':id', $id);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete existing record
     *
     * @param string $table_name
     * @param array $data
     * @param mixed $id
     * @return bool
     */
    public function delete(string $table_name, mixed $id): bool
    {
        try {
            $record = $this->find($table_name, 'id', $id);

            if (!$record) {
                return throw new Exception("Record not found");
            }

            $sql = "DELETE FROM $table_name WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
            return false;
        }
    }
}
