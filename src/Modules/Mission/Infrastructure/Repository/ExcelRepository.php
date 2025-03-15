<?php

namespace App\Modules\Mission\Infrastructure\Repository;

use App\Ddd\Domain\Entity\Mission;
use App\Ddd\Domain\Repository\MissionRepositoryInterface;

class ExcelRepository implements MissionRepositoryInterface
{

    public function save(Mission $mission): void
    {
        //some excel operations
        // TODO: Implement save() method.
    }
}