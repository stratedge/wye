<?php

namespace Tests\Collections\BindingCollection;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class HasDataTypeTest extends \Tests\TestCase
{
    public function testReturnsTrueWithMatches()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_STR);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_INT);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_BOOL);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $this->assertTrue($collection->hasDataType(PDO::PARAM_STR));
    }

    public function testReturnsFalseWithNoMatches()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_STR);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_STR);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_STR);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $this->assertFalse($collection->hasDataType(PDO::PARAM_BOOL));
    }
}
