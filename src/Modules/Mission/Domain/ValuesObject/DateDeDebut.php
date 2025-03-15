<?php

namespace App\Modules\Mission\Domain\ValuesObject;

use DateTime;

class DateDeDebut
{
    private \DateTimeInterface $value;

    public function __construct(\DateTimeImmutable $value) {
        $today = new DateTime();
        $today->setTime(0, 0, 0);

        if ($value < $today) {
            throw new \InvalidArgumentException("La date de début ne peut pas être dans le passé.");
        }

        $this->value = $value;
    }

    public function getValue(): \DateTimeInterface {
        return $this->value;
    }
}
