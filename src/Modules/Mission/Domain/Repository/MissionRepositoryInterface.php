<?php

namespace App\Modules\Mission\Domain\Repository;
use App\Modules\Mission\Domain\Entity\Mission;

interface MissionRepositoryInterface
{
    public function save(Mission $mission): void;

    public function getById(string $id): Mission;

    public function getAll(): array;
}