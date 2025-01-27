<?php

namespace App\Core\Contracts;

interface Command {
    public static function instance(): static;
    public function getOptionName(): string;
    public function handle(): void;
}