<?php

namespace App\Shared\Auth\Domain\Repository;

use App\Shared\Auth\Domain\Entity\User;

interface AuthUserRepositoryInterface
{
    public function findByUsername(string $username): ?User;
    public function save(User $user): void;

    public function getAll(): array;

}