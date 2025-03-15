<?php

namespace App\Shared\Auth\Infrastructure\Repository;

use App\Shared\Auth\Domain\Entity\User;
use App\Shared\Auth\Domain\Enum\RoleEnum;
use App\Shared\Auth\Domain\Repository\AuthUserRepositoryInterface;
use Ramsey\Uuid\Uuid;

class InFileMemoryAuthUserRepository implements AuthUserRepositoryInterface
{
    private array $users = [];
    private string $file = __DIR__ . '/users.json';

    public function __construct()
    {
        $this->loadUsers();
    }

    private function loadUsers(): void
    {
        if (file_exists($this->file)) {
            $data = json_decode(file_get_contents($this->file), true);
            if (is_array($data)) {
                foreach ($data as $userData) {
                    $this->users[$userData['id']] = new User(
                        Uuid::fromString($userData['id']),
                        $userData['username'],
                        $userData['password'],
                        array_map(fn(string $role) => RoleEnum::tryFrom($role), array_filter($userData['roles']))
                    );
                }
            }
        } else {
            $this->initUsers();
        }
    }


    private function initUsers(): void
    {
        $adminId = Uuid::uuid4()->toString();
        $this->users[$adminId] = new User(Uuid::fromString($adminId),
            'admin',
            '$2y$10$kA7ST9SoTdZhKdjg0B4DzOURkTrLRKEGQg0L8McaomUG3UypQGspa', // Password123
                [RoleEnum::ADMIN, RoleEnum::USER]
        );
        $this->saveToFile();
    }

    private function saveToFile(): void
    {
        $data = array_map(fn(User $user) => [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'roles' => array_map(fn(RoleEnum $role) => $role->value, $user->getRoles()),
        ], $this->users);

        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }


    public function findByUsername(string $username): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }
        return null;
    }

    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
        $this->saveToFile();
    }

    public function getAll(): array
    {
        return array_values($this->users);
    }

}
