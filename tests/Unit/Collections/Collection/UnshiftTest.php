<?php

namespace Tests\Unit\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class UnshiftTest extends \Tests\TestCase
{
    public function testAddsItem()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $collection->unshift(4);

        $this->assertSame([4, 1, 2, 3], $collection->all());
    }

    public function testAddsItems()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $collection->unshift(4, 5, 6);

        $this->assertSame([4, 5, 6, 1, 2, 3], $collection->all());
    }

    public function testChecksType()
    {
        $collection = new Collection(new Wye, [1, 2, 3], 'integer');

        $this->expectException(InvalidArgumentException::class);

        $collection->unshift('hello');
    }

    public function testReturnsSelf()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame($collection, $collection->unshift(4));
    }
}
