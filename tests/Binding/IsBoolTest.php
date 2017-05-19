<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsBoolTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL);

        $this->assertTrue($binding->isBool());
    }

    public function testReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT);

        $this->assertFalse($binding->isBool());
    }

    public function testPartOfInputOutputReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $this->assertTrue($binding->isBool());
    }

    public function testNotPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isBool());
    }
}
