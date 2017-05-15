<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class GetValueTest extends \Tests\TestCase
{
    public function testRetrievesValue()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->assertSame('Engine', $binding->getValue());
    }
}
