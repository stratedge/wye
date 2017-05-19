<?php

namespace Tests\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class PushTest extends \Tests\TestCase
{
    public function testAddsItem()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $collection->push(4);

        $this->assertSame([1, 2, 3, 4], $collection->all());
    }

    public function testAddsItems()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $collection->push(4, 5, 6);

        $this->assertSame([1, 2, 3, 4, 5, 6], $collection->all());
    }

    public function testChecksType()
    {
        $collection = new Collection(new Wye, [1, 2, 3], 'integer');

        $this->expectException(InvalidArgumentException::class);

        $collection->push('hello');
    }

    public function testReturnsSelf()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame($collection, $collection->push(4));
    }
}
