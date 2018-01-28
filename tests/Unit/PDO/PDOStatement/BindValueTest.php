<?php

namespace Tests\Unit\PDO\PDOStatement;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class BindValueTest extends \Tests\TestCase
{
    public function testPushesNewBindingWithData()
    {
        $statement = new PDOStatement(new Wye, '', []);

        $statement->bindValue(1, 'Rescue 1', PDO::PARAM_BOOL);
        $statement->bindValue('type', 'Squad', PDO::PARAM_INT);

        $bindings = $statement->getBindings();

        $this->assertSame(1, $bindings[0]->getParameter());
        $this->assertSame('Rescue 1', $bindings[0]->getValue());
        $this->assertTrue($bindings[0]->isBoolean());

        $this->assertSame('type', $bindings[1]->getParameter());
        $this->assertSame('Squad', $bindings[1]->getValue());
        $this->assertTrue($bindings[1]->isInteger());
    }

    public function testSetDefaultDataTypeAsString()
    {
        $statement = new PDOStatement(new Wye, '', []);

        $statement->bindValue(1, 'Rescue 1');

        $bindings = $statement->getBindings();

        $this->assertTrue($bindings[0]->isString());
    }

    public function testReturnsTrue()
    {
        $statement = new PDOStatement(new Wye, '', []);

        $result = $statement->bindValue(1, 'Engine 4');

        $this->assertTrue($result);
    }
}
