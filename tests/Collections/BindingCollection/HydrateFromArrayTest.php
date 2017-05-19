<?php

namespace Tests\Collections\BindingCollection;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class HydrateFromArrayTest extends \Tests\TestCase
{
    public function testClearsOldValues()
    {
        $original = new Binding(new Wye, 'apparatus', 'Engine');

        $collection = new BindingCollection(new Wye, [$original]);

        $collection->hydrateFromArray(['Ladder']);

        $this->assertNotSame($original, current($collection->all()));
        $this->assertNotSame([$original], $collection->all());
    }

    public function testShiftsNumericalIndexes()
    {
        $collection = new BindingCollection(new Wye);

        $collection->hydrateFromArray([
            'first',
            'second',
            'third',
        ]);

        $this->assertSame(1, $collection[0]->getParameter());
        $this->assertSame(2, $collection[1]->getParameter());
        $this->assertSame(3, $collection[2]->getParameter());
    }

    public function testStringIndexes()
    {
        $collection = new BindingCollection(new Wye);

        $collection->hydrateFromArray([
            'apparatus' => 'Engine 1',
            'type' => 'Pumper',
        ]);

        $this->assertSame('apparatus', $collection[0]->getParameter());
        $this->assertSame('type', $collection[1]->getParameter());
    }

    public function testUsesValuesWithNumericIndexes()
    {
        $collection = new BindingCollection(new Wye);

        $collection->hydrateFromArray([
            'Engine 1',
            'Pumper',
        ]);

        $this->assertSame('Engine 1', $collection[0]->getValue());
        $this->assertSame('Pumper', $collection[1]->getValue());
    }

    public function testUsesValuesWithStringIndexes()
    {
        $collection = new BindingCollection(new Wye);

        $collection->hydrateFromArray([
            'apparatus' => 'Engine 1',
            'type' => 'Pumper',
        ]);

        $this->assertSame('Engine 1', $collection[0]->getValue());
        $this->assertSame('Pumper', $collection[1]->getValue());
    }

    public function testUsesStringType()
    {
        $collection = new BindingCollection(new Wye);

        $collection->hydrateFromArray([
            'Engine 1',
            'Pumper',
        ]);

        $this->assertTrue($collection[0]->isString());
        $this->assertTrue($collection[1]->isString());
    }

    public function testReturnsSelf()
    {
        $collection = new BindingCollection(new Wye);

        $result = $collection->hydrateFromArray([
            'Engine 1',
            'Pumper',
        ]);

        $this->assertSame($collection, $result);
    }
}
