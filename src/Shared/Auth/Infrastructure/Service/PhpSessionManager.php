<?php

namespace App\Shared\Auth\Infrastructure\Service;

use App\Shared\Auth\Domain\Entity\User;
use App\Shared\Auth\Domain\Service\SessionManagerInterface;

class PhpSessionManager implements SessionManagerInterface
{
    public function start(): void
    {
        session_start();
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    public function getUser(): ?User
    {
        return $_SESSION['user'] ?? null;
    }


    public function setUser(User $user): void
    {
        $_SESSION['user'] = $user;
    }
}