<?php

namespace App\Core\Contracts;

interface ServiceContainer {
    public function bind(string $interface, string|callable $concrete=null): void;
    public function singleton(string $interface, string|callable $concrete=null): void;
    public function make(string $interface): object;
}