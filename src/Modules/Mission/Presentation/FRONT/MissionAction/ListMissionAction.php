<?php

namespace App\Modules\Mission\Presentation\FRONT\MissionAction;

use App\Modules\Mission\Application\UseCase\ListMissionUseCase;
use App\Modules\Mission\Domain\Entity\Mission;
use App\Shared\Auth\Domain\Service\SessionManagerInterface;
use App\Shared\Presentation\ActionTrait;

class ListMissionAction
{
    use ActionTrait;

    public function __construct(
        private readonly SessionManagerInterface $sessionManager,
        private readonly ListMissionUseCase $listMissionUseCase,
    )
    {
    }

    public function __invoke()
    {
        if($this->isGetRequest()) {
            $this->listMissions();
            return;
        }

        $this->throwNotFoundException();
    }

    private function listMissions(): void
    {
        $missions = $this->listMissionUseCase->handle();
        $missions = array_map(function(Mission $mission) {
            return [
                'id' => $mission->getId(),
                'nom' => $mission->getNom()->getValue(),
                'dateDeDebut' => $mission->getDateDeDebut()->getValue()->format('d/m/Y'),
                'dateDeFin' => $mission->getDateDeFin()->getValue()->format('d/m/Y'),
                'capacite' => $mission->getCapacite()->getValue(),
            ];
        }, $missions);
        $output = [
            'missions' => $missions,
            'currentUser' => $this->sessionManager->getUser(),
        ];

        include __DIR__ . '/show-missions.html';
    }


}