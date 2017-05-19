<?php

namespace Tests\Collections\BindingCollection;

use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class FilterByValueLikeTest extends \Tests\TestCase
{
    public function testReturnsNewOfSameType()
    {
        $collection = new BindingCollection(new Wye);

        $result = $collection->filterByValueLike('test');

        $this->assertInstanceOf(get_class($collection), $result);
        $this->assertNotSame($collection, $result);
    }

    public function testReturnsMatches()
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

        $result = $collection->filterByValueLike('um');

        $this->assertSame(1, count($result));
        $this->assertSame([$second], $result->values()->all());
    }
}
