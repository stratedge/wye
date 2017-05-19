<?php

namespace Tests\Binding;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class GetDataTypeTest extends \Tests\TestCase
{
    public function testRetrievesDataType()
    {
        $binding = new Binding(new Wye, 'truck', 'Engine', PDO::PARAM_STR);

        $this->assertSame(PDO::PARAM_STR, $binding->getDataType());
    }
}
