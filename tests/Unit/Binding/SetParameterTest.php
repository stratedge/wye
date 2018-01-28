<?php

namespace Tests\Unit\Binding;

use InvalidArgumentException;
use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class SetParameterTest extends \Tests\TestCase
{
    public function testSetsStringParameter()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $binding->setParameter('apparatus');

        $this->assertSame('apparatus', $binding->getParameter());
    }

    public function testSetsIntegerParameter()
    {
        $binding = new Binding(new Wye, 1, 'Engine', PDO::PARAM_STR);

        $binding->setParameter(3);

        $this->assertSame(3, $binding->getParameter());
    }

    public function testInvalidValueThrowsException()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->expectException(InvalidArgumentException::class);

        $binding->setParameter([]);
    }
}
