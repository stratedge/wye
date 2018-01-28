<?php

namespace Tests\Unit\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class CountableTest extends \Tests\TestCase
{
    public function testCount()
    {
        $collection = new Collection(new Wye);

        $this->assertSame(0, count($collection));

        $collection[] = 1;

        $this->assertSame(1, count($collection));

        $collection[] = 1;

        $this->assertSame(2, count($collection));

        unset($collection[0]);

        $this->assertSame(1, count($collection));
    }
}
