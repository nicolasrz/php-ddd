<?php

namespace App\Shared\Auth\Domain\Entity;


use App\Shared\Auth\Domain\Enum\RoleEnum;

class User
{
    public function __construct(
        private readonly string $id,
        private readonly string $username,
        private readonly string $password,
        private array $roles = []
    ){
        if(empty($roles)){
            $this->roles = [RoleEnum::USER];
        }
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isAdmin(): bool
    {
        return in_array(RoleEnum::ADMIN->name, array_map(fn($role) => $role->name, $this->roles));
    }

}