<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsNullTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_NULL);

        $this->assertTrue($binding->isNull());
    }

    public function testReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT);

        $this->assertFalse($binding->isNull());
    }

    public function testPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_NULL | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isNull());
    }

    public function testNotPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isNull());
    }
}
