<?php

namespace Tests\Unit\PDO\PDOStatement;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class MetaTest extends \Tests\TestCase
{
    public function testSetsWye()
    {
        $wye = new Wye;

        $stmt = new PDOStatement($wye, '', []);

        $this->assertSame($wye, $stmt->getWye());
    }

    public function testSetsStatement()
    {
        $stmt = new PDOStatement(new Wye, 'SELECT * FROM `apparatus`', []);

        $this->assertSame('SELECT * FROM `apparatus`', $stmt->getStatement());
    }

    public function testSetsOptions()
    {
        $stmt = new PDOStatement(new Wye, '', ['tool' => 'halligan']);

        $this->assertSame(['tool' => 'halligan'], $stmt->getOptions());
    }

    public function testInitializesEmptyBindingCollection()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $this->assertInstanceOf(BindingCollection::class, $stmt->getBindings());
        $this->assertTrue($stmt->getBindings()->isEmpty());
    }
}
