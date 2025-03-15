<?php

namespace App\Modules\Mission\Domain\Entity;

class Interimaire
{

    public function __construct(
        private readonly string $nom,
        private readonly string $prenom,
        private readonly array $qualifications,
    )
    {
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getQualifications(): array
    {
        return $this->qualifications;
    }


}