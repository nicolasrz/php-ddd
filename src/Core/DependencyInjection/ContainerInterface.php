<?php

namespace App\Core\DependencyInjection;

interface ContainerInterface
{
    public function get(string $id): object;
    public function has(string $id): bool;
} 