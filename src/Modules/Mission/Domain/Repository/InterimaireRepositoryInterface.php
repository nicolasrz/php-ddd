<?php

namespace App\Modules\Mission\Domain\Repository;

use App\Modules\Mission\Domain\Entity\Interimaire;

interface InterimaireRepositoryInterface
{
    public function save(Interimaire $interimaire): void;

    public function getById(int $id): Interimaire;
}