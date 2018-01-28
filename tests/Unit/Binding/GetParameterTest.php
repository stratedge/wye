<?php

namespace Tests\Unit\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class GetParameterTest extends \Tests\TestCase
{
    public function testRetrievesParameter()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->assertSame('truck', $binding->getParameter());
    }
}
