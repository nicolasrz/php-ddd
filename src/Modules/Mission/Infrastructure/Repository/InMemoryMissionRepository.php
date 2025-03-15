<?php

namespace App\Modules\Mission\Infrastructure\Repository;

use App\Modules\Mission\Domain\Entity\Mission;
use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;
use App\Modules\Mission\Domain\ValuesObject\CapaciteMax;
use App\Modules\Mission\Domain\ValuesObject\DateDeDebut;
use App\Modules\Mission\Domain\ValuesObject\DateDeFin;
use App\Modules\Mission\Domain\ValuesObject\Nom;
use Ramsey\Uuid\Uuid;

class InMemoryMissionRepository implements MissionRepositoryInterface
{
    private array $missions = [];

    public function __construct()
    {
        $this->missions = [
            new Mission(Uuid::uuid4()->toString(), new Nom('Mission 10'), new DateDeDebut(new \DateTime('2026-01-01')), new DateDeFin(new \DateTime('2026-01-02')), new CapaciteMax(10)),
            new Mission(Uuid::uuid4()->toString(), new Nom('Mission 20'), new DateDeDebut(new \DateTime('2026-01-10')), new DateDeFin(new \DateTime('2026-01-20')), new CapaciteMax(4)),
        ];
    }

    public function save(Mission $mission): void
    {
        $this->missions[] = $mission;
    }

    public function getAll(): array
    {
        return $this->missions;
    }

    public function getById(string $id): Mission
    {
        return array_filter($this->missions, function(Mission $mission) use ($id) {
            return $mission->getId() === $id;
        })[0];
    }
}