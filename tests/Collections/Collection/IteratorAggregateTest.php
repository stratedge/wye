<?php

namespace Tests\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class InteratorAggregateTest extends \Tests\TestCase
{
    public function testCanForeachThroughValues()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $all = $collection->all();

        foreach ($collection as $key => $value) {
            $this->assertSame($all[$key], $value);
        }
    }
}
