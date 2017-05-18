<?php

namespace Tests\Wye;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class MakeBindingTest extends \Tests\TestCase
{
    public function testReturnsBinding()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine');

        $this->assertInstanceOf(Binding::class, $binding);
    }

    public function testSetsWye()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine');

        $this->assertInstanceOf(Wye::class, $binding->getWye());
    }

    public function testSetsParameter()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine');

        $this->assertSame('apparatus', $binding->getParameter());
    }

    public function testSetsValue()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine');

        $this->assertSame('Engine', $binding->getValue());
    }

    public function testSetsDefaultDateType()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine');

        $this->assertSame(PDO::PARAM_STR, $binding->getDataType());
    }

    public function testSetsDateType()
    {
        $wye = new Wye;

        $binding = $wye->makeBinding('apparatus', 'Engine', PDO::PARAM_BOOL);

        $this->assertSame(PDO::PARAM_BOOL, $binding->getDataType());
    }
}
