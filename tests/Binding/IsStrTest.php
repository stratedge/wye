<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsStrTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->assertTrue($binding->isStr());
    }

    public function testReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL);

        $this->assertFalse($binding->isStr());
    }

    public function testPartOfInputOutputReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);

        $this->assertTrue($binding->isStr());
    }

    public function testNotPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isStr());
    }
}


