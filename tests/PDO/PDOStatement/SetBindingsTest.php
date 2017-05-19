<?php

namespace Tests\PDO\PDOStatement;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class SetBindingsTest extends \Tests\TestCase
{
    public function testReturnsSelf()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $result = $stmt->setBindings(new BindingCollection(new Wye));

        $this->assertSame($stmt, $result);
    }

    public function testSetsBindingsPropertyValue()
    {
        $stmt = new PDOStatement(new Wye, '', []);

        $collection = new BindingCollection(new Wye);

        $stmt->setBindings($collection);

        $this->assertSame($collection, $stmt->getBindings());
    }
}
