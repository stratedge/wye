<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class AllTest extends \Tests\TestCase
{
    public function testReturnsArray()
    {
        $collection = new Collection(new Wye);

        $this->assertInternalType('array', $collection->all());
    }

    public function testReturnsItems()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame([1, 2, 3], $collection->all());
    }
}
