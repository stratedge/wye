<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class ShiftTest extends \Tests\TestCase
{
    public function testReturnsFirstItem()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $this->assertSame(12, $collection->shift());
    }

    public function testAltersItems()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $collection->shift();

        $this->assertSame([665, 23, 'test', 345, 756], $collection->all());
    }
}
