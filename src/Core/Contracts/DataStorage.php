<?php

namespace App\Core\Contracts;

use App\Core\Enums\Operation;

interface DataStorage
{
    public function all(string $table_name): array;
    public function find(string $table_name, string $column_name, $value): array;
    public function findAll(string $table_name, array $conditions, Operation $operation, int $offset = 0, int $limit = 0): array;
    public function findCount(string $table_name, array $conditions = [], Operation $operation): int;
    public function create(string $table_name, array $data): bool;
    public function update(string $table_name, array $data, mixed $id): bool;
    public function delete(string $table_name, mixed $id): bool;
}
