<?php

namespace App\Modules\Mission\Domain\Entity;

use App\Modules\Mission\Domain\Exception\InterimaireDejaDansLaMission;
use App\Modules\Mission\Domain\ValuesObject\CapaciteMax;
use App\Modules\Mission\Domain\ValuesObject\DateDeDebut;
use App\Modules\Mission\Domain\ValuesObject\DateDeFin;
use App\Modules\Mission\Domain\ValuesObject\Nom;

class Mission
{
    public function __construct(
        private readonly string              $id,
        private readonly Nom         $nom,
        private readonly DateDeDebut $dateDeDebut,
        private readonly DateDeFin   $dateDeFin,
        private readonly CapaciteMax $capacite,
        private array                $interimaires = [],
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function addInterimaire(Interimaire $interimaire) : void
    {
        if (in_array($interimaire, $this->interimaires, true)) {
            throw new InterimaireDejaDansLaMission();
        }

        $this->interimaires[] = $interimaire;
    }

    public function estPleine(): bool
    {
        return $this->capacite->getValue() === count($this->interimaires) ;
    }

    public function getNom(): Nom
    {
        return $this->nom;
    }

    public function getDateDeDebut(): DateDeDebut
    {
        return $this->dateDeDebut;
    }

    public function getDateDeFin(): DateDeFin
    {
        return $this->dateDeFin;
    }

    public function getCapacite(): CapaciteMax
    {
        return $this->capacite;
    }

    public function getInterimaires(): array
    {
        return $this->interimaires;
    }



}