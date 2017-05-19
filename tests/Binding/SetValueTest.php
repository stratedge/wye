<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class SetValueTest extends \Tests\TestCase
{
    public function testSetsValue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $binding->setValue('Rescue');

        $this->assertSame('Rescue', $binding->getValue());
    }
}
