<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsIntTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT);

        $this->assertTrue($binding->isInt());
    }

    public function testReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL);

        $this->assertFalse($binding->isInt());
    }

    public function testPartOfInputOutputReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);

        $this->assertTrue($binding->isInt());
    }

    public function testNotPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isInt());
    }
}


