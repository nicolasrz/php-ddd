<?php

namespace App\Modules\Mission\Application\UseCase;

use App\Modules\Mission\Domain\Entity\Interimaire;
use App\Modules\Mission\Domain\Entity\Mission;
use App\Modules\Mission\Domain\Exception\MissionPleineException;
use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;

class AjouterInterimaireAUneMissionUseCase
{
    public function __construct(
        private readonly MissionRepositoryInterface $missionRepository,
    )
    {
    }

    public function handle(Mission $mission, Interimaire $interimaire): void
    {
        if($mission->estPleine()){
            throw new MissionPleineException();
        }
        $mission->addInterimaire($interimaire);
        $this->missionRepository->save($mission);
    }
}