<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\CollectionInterface;
use Stratedge\Wye\Wye;

class MapTest extends \Tests\TestCase
{
    public function testAppliesCallback()
    {
        $collection = Wye::makeCollection(['first', 'second']);

        $new = $collection->map(function ($item) {
            return $item . $item;
        });

        $this->assertCount(2, $new);
        $this->assertSame('firstfirst', $new[0]);
        $this->assertSame('secondsecond', $new[1]);
    }

    public function testReturnsNewCollection()
    {
        $collection = Wye::makeCollection(['first', 'second']);

        $new = $collection->map(function ($item) {
            return $item . $item;
        });

        $this->assertInstanceOf(CollectionInterface::class, $new);
    }
}
