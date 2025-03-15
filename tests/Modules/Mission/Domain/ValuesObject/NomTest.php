<?php

use PHPUnit\Framework\TestCase;
use App\Modules\Mission\Domain\ValuesObject\Nom;

class NomTest extends TestCase
{
    public function testNomValide()
    {
        $nom = new Nom('Mission Test');
        $this->assertEquals('Mission Test', $nom->getValue());
    }

    public function testNomInferiereA10Char()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Nom('123456789');
    }

}