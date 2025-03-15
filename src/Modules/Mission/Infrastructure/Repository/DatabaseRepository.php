<?php

namespace App\Modules\Mission\Infrastructure\Repository;

use App\Ddd\Domain\Entity\Mission;
use App\Ddd\Domain\Repository\MissionRepositoryInterface;

class DatabaseRepository implements MissionRepositoryInterface
{
    //some pdo
    public function save(Mission $mission) : void {
        //some insert
    }
}