<?php

namespace App\Modules\Mission\Application\UseCase;

use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;

class ListMissionUseCase
{
    public function __construct(
        private readonly MissionRepositoryInterface $missionRepository,
    )
    {
    }

    public function handle(): array
    {
        return $this->missionRepository->getAll();
    }

}