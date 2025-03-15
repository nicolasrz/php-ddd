<?php

namespace App\Shared\Auth\Domain\Security;

use App\Shared\Auth\Domain\Entity\User;

interface PolicyInterface
{
    public function can(User $user, string $action, mixed $subject = []): bool;
}   