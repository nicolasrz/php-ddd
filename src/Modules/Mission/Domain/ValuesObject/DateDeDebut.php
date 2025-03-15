<?php

namespace App\Modules\Mission\Domain\ValuesObject;

use DateTime;

class DateDeDebut
{
    private DateTime $value;

    public function __construct(DateTime $value) {
        $today = new DateTime();
        $today->setTime(0, 0, 0);

        if ($value < $today) {
            throw new \InvalidArgumentException("La date de début ne peut pas être dans le passé.");
        }

        $this->value = $value;
    }

    public function getValue(): DateTime {
        return $this->value;
    }
}
