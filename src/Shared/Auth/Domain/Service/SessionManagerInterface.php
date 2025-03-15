<?php

namespace App\Shared\Auth\Domain\Service;


use App\Shared\Auth\Domain\Entity\User;

interface SessionManagerInterface
{
    public function start(): void;
    public function set(string $key, $value): void;
    public function get(string $key);
    public function has(string $key): bool;
    public function remove(string $key): void;
    public function destroy(): void;
    public function isAuthenticated(): bool;
    public function getUser(): ?User;
    public function setUser(User $user): void;
}