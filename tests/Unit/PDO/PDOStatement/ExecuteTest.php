<?php

namespace Tests\Unit\PDO\PDOStatement;

use PDO;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class ExecuteTest extends TestCase
{
    public function testReturnsTrue()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertTrue($statement->execute());
    }

    public function testParamsSetsBindingsOnStatementWithNumericalIndexes()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertTrue($statement->getBindings()->isEmpty());

        $statement->execute(['Ladder 3', 'Quint']);

        $collection = $statement->getBindings();

        $this->assertSame(1, $collection[0]->getParameter());
        $this->assertSame('Ladder 3', $collection[0]->getValue());
        $this->assertSame(PDO::PARAM_STR, $collection[0]->getDataType());

        $this->assertSame(2, $collection[1]->getParameter());
        $this->assertSame('Quint', $collection[1]->getValue());
        $this->assertSame(PDO::PARAM_STR, $collection[1]->getDataType());
    }

    public function testParamsSetsBindingsOnStatementWithStringIndexes()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertTrue($statement->getBindings()->isEmpty());

        $statement->execute(['apparatus' => 'Ladder 3', 'type' => 'Quint']);

        $collection = $statement->getBindings();

        $this->assertSame('apparatus', $collection[0]->getParameter());
        $this->assertSame('Ladder 3', $collection[0]->getValue());
        $this->assertSame(PDO::PARAM_STR, $collection[0]->getDataType());

        $this->assertSame('type', $collection[1]->getParameter());
        $this->assertSame('Quint', $collection[1]->getValue());
        $this->assertSame(PDO::PARAM_STR, $collection[1]->getDataType());
    }

    public function testNoParamsMaintainsBindings()
    {
        $statement = Wye::makeStatement("", []);

        $collection = new BindingCollection(new Wye);

        $statement->setBindings($collection);

        $this->assertSame($collection, $statement->getBindings());

        $statement->bindValue(1, 'Engine 3');

        $this->assertSame(1, count($statement->getBindings()));

        $statement->execute();

        $this->assertSame(1, count($statement->getBindings()));
    }

    public function testResultSetOnStatement()
    {
        $statement = Wye::makeStatement("", []);

        //Make sure the default is null
        $this->assertNull($statement->result());

        $result = Wye::makeResult()
            ->attach();

        $statement->execute();

        $this->assertSame($result, $statement->result());
    }
}
