<?php

namespace Tests\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class ArrayAccessTest extends \Tests\TestCase
{
    public function testIsset()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertTrue(isset($collection[0]));
        $this->assertFalse(isset($collection[3]));
    }

    public function testGet()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
    }

    public function testSet()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);
        $collection[] = 4;
        $this->assertSame([1, 2, 3, 4], $collection->all());

        $collection = new Collection(new Wye, [1, 2, 3]);
        $collection[0] = 4;
        $this->assertSame([4, 2, 3], $collection->all());

        $collection = new Collection(new Wye, [1, 2, 3]);
        $collection[5] = 4;
        $this->assertSame(
            [1, 2, 3, 5 => 4],
            $collection->all()
        );

        $collection = new Collection(new Wye, [1, 2, 3]);
        $collection['Ladder'] = 4;
        $this->assertSame(
            [1, 2, 3, 'Ladder' => 4],
            $collection->all()
        );
    }

    public function testSetChecksType()
    {
        $collection = new Collection(new Wye, [1, 2, 3], 'integer');

        $this->expectException(InvalidArgumentException::class);

        $collection[] = 'Engine';
    }

    public function testUnset()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        unset($collection[1]);

        $this->assertSame([0 => 1, 2 => 3], $collection->all());
    }
}
