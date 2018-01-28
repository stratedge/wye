<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class MakeBindingCollectionTest extends \Tests\TestCase
{
    public function testReturnsBindingCollection()
    {
        $wye = new Wye;

        $collection = $wye->makeBindingCollection();

        $this->assertInstanceOf(BindingCollection::class, $collection);
    }

    public function testSetsWye()
    {
        $wye = new Wye;

        $collection = $wye->makeBindingCollection();

        $this->assertInstanceOf(Wye::class, $collection->getWye());
    }

    public function testSetsDefaultItems()
    {
        $wye = new Wye;

        $collection = $wye->makeBindingCollection();

        $this->assertSame([], $collection->all());
    }

    public function testSetsItems()
    {
        $wye = new Wye;

        $items = [
            $wye->makeBinding('apparatus', 'Engine'),
        ];

        $collection = $wye->makeBindingCollection($items);

        $this->assertSame($items, $collection->all());
    }
}
