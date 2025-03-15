<?php

namespace App\Modules\Auth\Application\Service;

use App\Modules\Auth\Domain\Service\CheckPasswordInterface;
use App\Shared\Auth\Domain\Entity\User;
use App\Shared\Auth\Domain\Service\SessionManagerInterface;
use Ramsey\Uuid\Uuid;

class AuthenticationService
{
    public function __construct(
        private readonly CheckPasswordInterface $checkPassword,
        private readonly SessionManagerInterface $sessionManager
    ) {
    }

    public function createUser(string $username, string $plainPassword): User
    {
        $hashedPassword = $this->checkPassword->hash($plainPassword);
        return new User(Uuid::uuid4()->toString(), $username, $hashedPassword);
    }

    public function login(User $user, string $plainPassword): bool
    {
        if ($this->checkPassword->check($plainPassword, $user->getPassword())) {
            $this->sessionManager->setUser($user);
            return true;
        }
        return false;
    }
}