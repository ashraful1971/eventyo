<?php

namespace App\Core\Contracts;

interface ServiceProvider {
    public function register(ServiceContainer $container): void;
}