<?php

namespace App\Modules\Mission\Domain\ValuesObject;

class Nom
{
    private string $value;

    public function __construct(string $value) {
        $value = trim($value);

        if (strlen($value) < 10) {
            throw new \InvalidArgumentException("Le nom doit faire au moins 10 caractères.");
        }

        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}
