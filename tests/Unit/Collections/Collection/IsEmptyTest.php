<?php

namespace Tests\Unit\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class IsEmptyTest extends \Tests\TestCase
{
    public function testNoItemsReturnsTrue()
    {
        $collection = new Collection(new Wye);

        $this->assertTrue($collection->isEmpty());
    }

    public function testItemsReturnsFalse()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertFalse($collection->isEmpty());
    }
}
