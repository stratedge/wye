<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class LastTest extends \Tests\TestCase
{
    public function testReturnsLastItem()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $this->assertSame(756, $collection->last());
    }

    public function testReturnsLastMatchedValue()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $callback = function ($value, $key) {
            return $value === 23;
        };

        $this->assertSame(23, $collection->last($callback));
    }

    public function testNoCallbackEmptyArrayReturnsNull()
    {
        $collection = new Collection(new Wye, []);

        $this->assertNull($collection->last());
    }

    public function testCallbackNotFoundReturnsDefault()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $callback = function ($value, $key) {
            return $value === 4;
        };

        $this->assertSame('Engine', $collection->last($callback, 'Engine'));
    }

    public function testDoesNotAlertItems()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $collection->last();

        $this->assertSame([12, 665, 23, 'test', 345, 756], $collection->all());

        $callback = function ($value, $key) {
            return $value === 23;
        };

        $collection->last($callback);

        $this->assertSame([12, 665, 23, 'test', 345, 756], $collection->all());
    }
}
