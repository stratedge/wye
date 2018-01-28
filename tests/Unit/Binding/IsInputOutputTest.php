<?php

namespace Tests\Unit\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class IsInputOutputTest extends \Tests\TestCase
{
    public function testReturnsTrue()
    {
        $contants = [
            PDO::PARAM_BOOL,
            PDO::PARAM_INT,
            PDO::PARAM_NULL,
            PDO::PARAM_STR,
            PDO::PARAM_LOB,
            PDO::PARAM_STMT
        ];

        foreach ($contants as $constant) {
            $binding = new Binding(new Wye, 'truck', 'Engine', ($constant | PDO::PARAM_INPUT_OUTPUT));
            $this->assertTrue($binding->isInputOutput());
        }
    }

    public function testReturnsFalse()
    {
        $contants = [
            PDO::PARAM_BOOL,
            PDO::PARAM_INT,
            PDO::PARAM_NULL,
            PDO::PARAM_STR,
            PDO::PARAM_LOB,
            PDO::PARAM_STMT
        ];

        foreach ($contants as $constant) {
            $binding = new Binding(new Wye, 'truck', 'Engine', $constant);
            $this->assertFalse($binding->isInputOutput());
        }
    }
}
