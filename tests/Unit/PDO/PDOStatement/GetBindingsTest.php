<?php

namespace Tests\Unit\PDO\PDOStatement;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Collections\BindingCollectionInterface;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class GetBindingsTest extends \Tests\TestCase
{
    public function testReturnsBindingCollection()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $this->assertInstanceOf(BindingCollectionInterface::class, $stmt->getBindings());
    }

    public function testReturnsBindingsPropertyValue()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $collection = new BindingCollection(new Wye);

        $stmt->setBindings($collection);

        $this->assertSame($collection, $stmt->getBindings());
    }
}
