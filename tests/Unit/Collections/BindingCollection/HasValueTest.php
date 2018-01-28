<?php

namespace Tests\Unit\Collections\BindingCollection;

use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class HasValueTest extends \Tests\TestCase
{
    public function testReturnsTrueWithMatches()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1');
        $second = new Binding(new Wye, 'type', 'Pumper');
        $third = new Binding(new Wye, 'seats', 5);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $this->assertTrue($collection->hasValue('Pumper'));
    }

    public function testReturnsFalseWithNoMatches()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1');
        $second = new Binding(new Wye, 'type', 'Pumper');
        $third = new Binding(new Wye, 'seats', 5);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $this->assertFalse($collection->hasValue('Quint'));
    }
}
