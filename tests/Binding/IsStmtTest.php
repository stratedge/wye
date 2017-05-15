<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsStmtTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STMT);

        $this->assertTrue($binding->isStmt());
    }

    public function testReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL);

        $this->assertFalse($binding->isStmt());
    }

    public function testPartOfInputOutputReturnsTrue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STMT | PDO::PARAM_INPUT_OUTPUT);

        $this->assertTrue($binding->isStmt());
    }

    public function testNotPartOfInputOutputReturnsFalse()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $this->assertFalse($binding->isStmt());
    }
}


