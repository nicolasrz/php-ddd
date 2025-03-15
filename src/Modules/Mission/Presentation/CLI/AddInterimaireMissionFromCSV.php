<?php

namespace App\Modules\Mission\Presentation\CLI;

use App\Ddd\Domain\Repository\MissionRepositoryInterface;
use App\Modules\Mission\Application\UseCase\AjouterInterimaireAUneMissionUseCase;
use App\Modules\Mission\Domain\Repository\InterimaireRepositoryInterface;

class AddInterimaireMissionFromCSV
{
    public function __construct(
        private readonly InterimaireRepositoryInterface       $interimaireRepository,
        private readonly MissionRepositoryInterface           $missionRepository,
        private readonly AjouterInterimaireAUneMissionUseCase $useCase,
    )
    {
    }

    public function execute(): void
    {
        $csvFilePath = '/private/interimaire/mission/file.csv';
        $data = [];

        if (!file_exists($csvFilePath) || !is_readable($csvFilePath)) {
            throw new \RuntimeException("Le fichier CSV est introuvable ou illisible.");
        }

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ';');

            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                $data[] = array_combine($headers, $row);
            }

            fclose($handle);
        }

        foreach ($data as $row) {
            $mission = $this->missionRepository->getById($row['missionId']);
            $interimaire = $this->interimaireRepository->getById($row['interimaireId']);
            try {
                $this->useCase->handle($mission, $interimaire);
            } catch (\Exception $e) {
                //mange exception
            }

            echo "SUCCESS";
        }
    }
}
