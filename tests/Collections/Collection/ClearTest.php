<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class ClearTest extends \Tests\TestCase
{
    public function testClearsItems()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame([1, 2, 3], $collection->all());

        $collection->clear();

        $this->assertSame([], $collection->all());
    }

    public function testReturnsSelf()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $result = $collection->clear();

        $this->assertSame($collection, $result);
    }
}
