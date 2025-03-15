<?php

namespace App\Modules\Mission\Presentation\API;

use App\Modules\Mission\Application\UseCase\AjouterInterimaireAUneMissionUseCase;
use App\Modules\Mission\Domain\Repository\InterimaireRepositoryInterface;
use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;

class PostInterimaireMissionAction
{
    public function __construct(
        private readonly MissionRepositoryInterface           $missionRepository,
        private readonly InterimaireRepositoryInterface       $interimaireRepository,
        private readonly AjouterInterimaireAUneMissionUseCase $useCase,
    )
    {
    }

    public function __invoke(): void
    {
        $data = $this->getInputData();
        $mission = $this->missionRepository->getById($data["missionId"]);
        $interimaire = $this->interimaireRepository->getById($data["interimaireId"]);
        try {
            $this->useCase->handle($mission, $interimaire);
        } catch (\Exception $exception) {
            //manage domain exception
        }

        $this->sendResponse();
    }

    private function getInputData() : array {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid JSON"]);
            return [];
        }

        return $data;
    }
    private function sendResponse(): void
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([]);
    }
}
