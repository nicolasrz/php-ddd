<?php

namespace App\Shared\Auth\Domain\Enum;

enum RoleEnum: string
{
    case ADMIN = 'ADMIN';
    case USER = 'USER';
}
