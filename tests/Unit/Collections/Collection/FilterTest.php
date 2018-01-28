<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class FilterTest extends \Tests\TestCase
{
    public function testReturnsNewOfSameType()
    {
        $collection = new Collection(new Wye);

        $result = $collection->filter();

        $this->assertInstanceOf(get_class($collection), $result);
        $this->assertNotSame($collection, $result);
    }

    public function testNoInputFiltersFalsey()
    {
        $arr = [
            null,
            true,
            false,
            -1,
            0,
            1,
            '-1',
            '0',
            '1',
            'test',
            [],
            ['test']
        ];

        $collection = new Collection(new Wye, $arr);

        $result = $collection->filter();

        $this->assertSame(
            [true, -1, 1, '-1', '1', 'test', ['test']],
            $result->values()->all()
        );
    }

    public function testCallbackFiltersOnValues()
    {
        $callback = function ($value, $key) {
            return $value % 2 == 0;
        };

        $collection = new Collection(new Wye, [1, 2, 3, 4]);

        $result = $collection->filter($callback);

        $this->assertEquals([2, 4], $result->values()->all());
    }

    public function testCallbackFiltersOnKeys()
    {
        $callback = function ($value, $key) {
            return $key % 2 == 0;
        };

        $collection = new Collection(new Wye, [1, 2, 3, 4]);

        $result = $collection->filter($callback);

        $this->assertEquals([1, 3], $result->values()->all());
    }
}
