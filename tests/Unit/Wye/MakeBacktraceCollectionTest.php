<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\BacktraceCollectionInterface;
use Stratedge\Wye\Wye;

class MakeBacktraceCollectionTest extends \Tests\TestCase
{
    public function testReturnsBacktraceCollectionInterface()
    {
        $collection = Wye::makeBacktraceCollection();

        $this->assertInstanceOf(BacktraceCollectionInterface::class, $collection);
    }

    public function testBacktraceCollectionContainsWye()
    {
        $collection = Wye::makeBacktraceCollection();

        $this->assertInstanceOf(Wye::class, $collection->getWye());
    }

    public function testContainsPassedItems()
    {
        $items = [
            'test' => 123,
            4,
            5
        ];

        $collection = Wye::makeBacktraceCollection($items);

        $this->assertSame($items, $collection->all());
    }
}
