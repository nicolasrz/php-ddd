<?php

namespace App\Modules\Auth\Domain\Service;

interface CheckPasswordInterface
{
    public function check(string $plainPassword, string $hashedPassword): bool;
}