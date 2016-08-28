<?php

namespace Tests\Wye;

use Stratedge\Wye\Wye;
use Stratedge\Wye\PDO\PDO;
use Tests\TestCase;

class MakePDOTest extends TestCase
{
    public function testReturnsPDO()
    {
        $pdo = Wye::makePDO();

        $this->assertInstanceOf(PDO::class, $pdo);
    }


    public function testSetsWyePropertyOnPDO()
    {
        $pdo = Wye::makePDO();

        $this->assertInstanceOf(Wye::class, $pdo->wye());
    }
}
