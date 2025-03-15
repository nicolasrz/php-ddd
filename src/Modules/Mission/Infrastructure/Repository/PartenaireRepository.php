<?php

namespace App\Modules\Mission\Infrastructure\Repository;

use App\Ddd\Domain\Entity\Mission;
use App\Ddd\Domain\Repository\MissionRepositoryInterface;

class PartenaireRepository implements MissionRepositoryInterface
{

    public function save(Mission $mission): void
    {
        //some call api
        // TODO: Implement save() method.
    }
}