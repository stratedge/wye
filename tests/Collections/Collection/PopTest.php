<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class PopTest extends \Tests\TestCase
{
    public function testReturnsLastItem()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $this->assertSame(756, $collection->pop());
    }

    public function testAltersItems()
    {
        $collection = new Collection(new Wye, [12, 665, 23, 'test', 345, 756]);

        $collection->pop();

        $this->assertSame([12, 665, 23, 'test', 345], $collection->all());
    }
}
