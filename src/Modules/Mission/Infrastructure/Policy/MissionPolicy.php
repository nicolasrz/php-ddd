<?php

namespace App\Modules\Mission\Infrastructure\Policy;

use App\Shared\Auth\Infrastructure\Security\AbstractPolicy;
use App\Shared\Auth\Domain\Entity\User;
use App\Modules\Mission\Domain\Entity\Mission;
use App\Shared\Auth\Domain\Enum\RoleEnum;


class MissionPolicy extends AbstractPolicy
{

    public function can(User $user, string $action, mixed $subject = []): bool
    {
        return match ($action) {
            'list' => $this->canList($user),
            'view' => $this->canView($user, $subject),
            'create' => $this->canCreate($user),
            'edit' => $this->canEdit($user, $subject),
            'delete' => $this->canDelete($user, $subject),
            default => false
        };      
    }

    private function canList(User $user): bool
    {
        return $this->hasRole($user, RoleEnum::USER);
    }

    private function canView(User $user, Mission $mission): bool
    {
        return $this->isOwner($user, $mission);
    }

    private function canCreate(User $user): bool
    {
        return $this->hasRole($user, RoleEnum::ADMIN);
    }

    private function canEdit(User $user, ?Mission $mission): bool
    {
        if (!$mission) return false;

        return $this->hasRole($user, RoleEnum::ADMIN) 
        ||  $this->isOwner($user, $mission);
    }

    private function canDelete(User $user, ?Mission $mission): bool
    {
        return $this->hasRole($user, RoleEnum::ADMIN)
        ||  $this->isOwner($user, $mission);
    }
    
    
}   