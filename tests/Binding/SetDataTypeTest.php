<?php

namespace Tests\Binding;

use InvalidArgumentException;
use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class SetDataTypeTest extends \Tests\TestCase
{
    public function testSetsDataType()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $binding->setDataType(PDO::PARAM_INT);

        $this->assertSame(PDO::PARAM_INT, $binding->getDataType());
    }

    public function testInvalidValueThrowsException()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->expectException(InvalidArgumentException::class);

        $binding->setDataType([]);
    }
}
