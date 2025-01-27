<?php

namespace App\Core;

use App\Core\Contracts\DataStorage;
use App\Core\Enums\Operation;

class Model
{
    protected $table_name;
    protected $columns;
    protected $attributes = [];
    protected $default = [];
    protected $is_new;

    /**
     * Constructor to init the props
     *
     * @param array $data
     */
    public function __construct(array $data = [], bool $is_new = true)
    {
        $this->attributes = array_merge($this->attributes, $data);
        $this->is_new = $is_new;
    }

    /**
     * Get the storage instance
     *
     * @return DataStorage
     */
    private static function getStorage(): DataStorage
    {
        return container()->make(DataStorage::class);
    }

    /**
     * Get the virtual property value
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        $accessor = strtolower('get' . $name . 'attribute');
        if (method_exists($this, $accessor)) {
            return $this->$accessor();
        }

        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Set the virtual property value
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get all the records
     *
     * @return array
     */
    public static function all(): array
    {
        $instance = new static();
        $records = $instance->getStorage()->all($instance->table_name);

        $collection = [];
        if ($records) {
            foreach ($records as $record) {
                $collection[] = new static($record, false);
            }
        }

        return $collection;
    }

    /**
     * Find the first value by column name and value or fail
     *
     * @param string $column_name
     * @param mixed $value
     * @return Model|null
     */
    public static function findOrFail(string $column_name, mixed $value): Model|null
    {
        $record = self::find($column_name, $value);

        if (!$record->id) {
            return Response::redirect('/404');
        }

        return $record;
    }

    /**
     * Find the first value by column name and value
     *
     * @param string $column_name
     * @param mixed $value
     * @return Model|null
     */
    public static function find(string $column_name, mixed $value): Model|null
    {

        $instance = new static();
        $record = $instance->getStorage()->find($instance->table_name, $column_name, $value);
        return $record ? new static($record, false) : null;

        return $instance;
    }
    
    /**
     * Find the first value by column name and value
     *
     * @param string $column_name
     * @param mixed $value
     * @return array
     */
    public static function findRaw(string $column_name, mixed $value): array
    {

        $instance = new static();
        $record = $instance->getStorage()->find($instance->table_name, $column_name, $value);

        return $record ?? [];
    }

    /**
     * Find all the records by column name and value
     *
     * @param array $conditions
     * @param Operation $operation
     * @return array
     */
    public static function findAll(array $conditions = [], Operation $operation = Operation::AND, int $offset = 0, int $limit = 0, string $order_by_column='id', $order_by_type='ASC'): array
    {
        $instance = new static();
        $records = $instance->getStorage()->findAll($instance->table_name, $conditions, $operation, $offset, $limit, $order_by_column, $order_by_type);

        if (!$records) {
            return [];
        }

        $models = [];

        foreach ($records as $record) {
            $models[] = new static($record, false);
        }

        return $models;
    }
    
    /**
     * Find all the records by column name and value
     *
     * @param array $conditions
     * @param Operation $operation
     * @return array
     */
    public static function findAllRaw(array $conditions = [], Operation $operation = Operation::AND, int $offset = 0, int $limit = 0, string $order_by_column='id', $order_by_type='ASC'): array
    {
        $instance = new static();
        $records = $instance->getStorage()->findAll($instance->table_name, $conditions, $operation, $offset, $limit, $order_by_column, $order_by_type);

        return $records ?? [];
    }
    
    /**
     * Find the count of the records by column name and value
     *
     * @param array $conditions
     * @param Operation $operation
     * @return int
     */
    public static function findCount(array $conditions = [], Operation $operation = Operation::AND): int
    {
        $instance = new static();
        $count = $instance->getStorage()->findCount($instance->table_name, $conditions, $operation);
        return $count;
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public static function create(array $data): Model
    {
        $instance = new static($data);
        $instance->save();

        return $instance;
    }

    /**
     * Update a new record
     *
     * @param array $data
     * @return Model
     */
    public static function update(int $id, array $data): Model
    {
        $instance = new static();
        $instance->getStorage()->update($instance->table_name, $data, $id);

        return $instance;
    }

    /**
     * Delete a new record
     *
     * @param mixed $did
     * @return boolean
     */
    public static function delete(mixed $id): bool
    {
        $instance = new static();
        return $instance->getStorage()->delete($instance->table_name, $id);
    }

    /**
     * Save the model to the storage
     *
     * @return boolean
     */
    public function save(): bool
    {
        $data = $this->getStoreableData();
        if ($this->is_new) {
            return $this->getStorage()->create($this->table_name, $data);
        }

        return $this->getStorage()->update($this->table_name, $data, $this->id);
    }

    /**
     * Get the data that matched the table schema
     *
     * @return array
     */
    private function getStoreableData(): array
    {
        $data = [];
        $data['id'] = $this->is_new ? generateUniqueId() : $this->id;

        foreach ($this->columns as $column) {
            $data[$column] = $this->attributes[$column] ?? $this->default[$column] ?? '';
        }

        if (in_array('created_at', $this->columns)) {
            $data['created_at'] = $this->is_new ? date(DATETIME_FORMAT) : $this->created_at;
        }

        if (in_array('updated_at', $this->columns)) {
            $data['updated_at'] = date(DATETIME_FORMAT);
        }

        return $data;
    }
}
