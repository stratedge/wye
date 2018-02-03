<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\CollectionInterface;
use Stratedge\Wye\Wye;

class MakeCollectionTest extends \Tests\TestCase
{
    public function testReturnsCollectionInterface()
    {
        $collection = Wye::makeCollection();

        $this->assertInstanceOf(CollectionInterface::class, $collection);
    }

    public function testCollectionContainsWye()
    {
        $collection = Wye::makeCollection();

        $this->assertInstanceOf(Wye::class, $collection->getWye());
    }

    public function testContainsPassedItems()
    {
        $items = [
            'test' => 123,
            4,
            5
        ];

        $collection = Wye::makeCollection($items);

        $this->assertSame($items, $collection->all());
    }
}
