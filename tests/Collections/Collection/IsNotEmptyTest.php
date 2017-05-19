<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class IsNotEmptyTest extends \Tests\TestCase
{
    public function testNoItemsReturnsFalse()
    {
        $collection = new Collection(new Wye);

        $this->assertFalse($collection->isNotEmpty());
    }

    public function testItemsReturnsTrue()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertTrue($collection->isNotEmpty());
    }
}
