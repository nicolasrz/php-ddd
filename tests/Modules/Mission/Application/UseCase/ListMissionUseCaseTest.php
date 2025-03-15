<?php

use App\Modules\Mission\Domain\ValuesObject\CapaciteMax;
use App\Modules\Mission\Domain\ValuesObject\DateDeDebut;
use App\Modules\Mission\Domain\ValuesObject\DateDeFin;
use App\Modules\Mission\Domain\ValuesObject\Nom;
use PHPUnit\Framework\TestCase;
use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;
use App\Modules\Mission\Domain\Entity\Mission;
use App\Modules\Mission\Application\UseCase\ListMissionUseCase;
use Ramsey\Uuid\Uuid;

class ListMissionUseCaseTest extends TestCase
{
    public function testListMission()
    {
        $missionRepository = $this->createMock(MissionRepositoryInterface::class);

        $missionRepository->method('getAll')->willReturn([
            new Mission(
                Uuid::uuid4()->toString(),
                new Nom('Mission 10'),
                new DateDeDebut(new DateTimeImmutable('+1 day')),
                new DateDeFin(new DateTimeImmutable('+2 day')),
                new CapaciteMax(10),
            ),
            new Mission(
                Uuid::uuid4()->toString(),
                new Nom('Mission 2O'),
                new DateDeDebut(new DateTimeImmutable('+1 day')),
                new DateDeFin(new DateTimeImmutable('+2 day')),
                new CapaciteMax(20),
            ),
        ]);

        $listMissionUseCase = new ListMissionUseCase($missionRepository);
        $missions = $listMissionUseCase->handle();

        $this->assertCount(2, $missions);
    }
}
