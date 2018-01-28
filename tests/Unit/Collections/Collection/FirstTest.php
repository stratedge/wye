<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class FirstTest extends \Tests\TestCase
{
    public function testReturnsFirstItem()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $this->assertSame(12, $collection->first());
    }

    public function testReturnsFirstMatchedValue()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $callback = function ($value, $key) {
            return $value === 23;
        };

        $this->assertSame(23, $collection->first($callback));
    }

    public function testNoCallbackEmptyArrayReturnsNull()
    {
        $collection = new Collection(new Wye, []);

        $this->assertNull($collection->first());
    }

    public function testCallbackNotFoundReturnsDefault()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $callback = function ($value, $key) {
            return $value === 4;
        };

        $this->assertSame('Engine', $collection->first($callback, 'Engine'));
    }

    public function testDoesNotAlertItems()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $collection->first();

        $this->assertSame([12, 665, 23, 'test', 345, 756], $collection->all());

        $callback = function ($value, $key) {
            return $value === 23;
        };

        $collection->first($callback);

        $this->assertSame([12, 665, 23, 'test', 345, 756], $collection->all());
    }
}
