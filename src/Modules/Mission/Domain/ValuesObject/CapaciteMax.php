<?php

namespace App\Modules\Mission\Domain\ValuesObject;

class CapaciteMax
{
    private int $value;

    public function __construct(int $value) {
        if ($value < 1) {
            throw new \InvalidArgumentException("La capacité doit être d'au moins 1.");
        }

        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }
}
