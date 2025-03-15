<?php

namespace App\Shared\Auth\Infrastructure\Security;

use App\Shared\Auth\Domain\Entity\User;
use App\Shared\Auth\Domain\Security\PolicyInterface;    
use App\Shared\Auth\Domain\Enum\RoleEnum;
abstract class AbstractPolicy implements PolicyInterface
{

    protected function hasRole(User $user, RoleEnum $role): bool
    {

        $userRoles = array_map(fn($role) => $role->value, $user->getRoles());
        return in_array($role->value, $userRoles);
    }   


  protected function isOwner(User $user, $subject): bool
    {
        return $user->getId() === $subject->getOwnerId();
    }


} 