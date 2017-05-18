<?php

namespace Tests\PDO\PDOStatement;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class GetBindingsTest extends \Tests\TestCase
{
    public function testReturnsBindingCollection()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $this->assertInstanceOf(BindingCollection::class, $stmt->getBindings());
    }

    public function testReturnsBindingsPropertyValue()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $collection = new BindingCollection(new Wye);

        $stmt->setBindings($collection);

        $this->assertSame($collection, $stmt->getBindings());
    }
}
