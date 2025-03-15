<?php

namespace App\Modules\Auth\Infrastructure\Service;

use App\Modules\Auth\Domain\Service\CheckPasswordInterface;

class BcryptPasswordHashing implements CheckPasswordInterface
{

    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

}