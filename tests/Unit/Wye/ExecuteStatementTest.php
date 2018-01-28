<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class ExecuteStatementTest extends TestCase
{
    public function testStatementAddedToListOfStatements()
    {
        //Statements start empty
        $this->assertEmpty(Wye::statements());

        $statement = Wye::makeStatement("SELECT * FROM `users`", []);

        Wye::executeStatement($statement);

        $statements = Wye::statements();

        $this->assertSame($statements[0], $statement);
    }

    public function testNonArrayParamsDoNotImpactBindings()
    {
        $stmt = Wye::makeStatement('', []);

        $collection = $this->getMockBuilder(BindingCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['hydrateFromArray'])
            ->getMock();

        $collection->expects($this->never())
            ->method('hydrateFromArray');

        $stmt->setBindings($collection);

        Wye::executeStatement($stmt);
    }

    public function testArrayParamsChangesBindings()
    {
        $stmt = Wye::makeStatement('', []);

        $params = ['Engine 1', 'Pumper'];

        $collection = $this->getMockBuilder(BindingCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['hydrateFromArray'])
            ->getMock();

        $collection->expects($this->once())
            ->method('hydrateFromArray')
            ->with($params);

        $stmt->setBindings($collection);

        Wye::executeStatement($stmt, $params);
    }

    public function testCorrespondingResultAddedToStatement()
    {
        $statement1 = Wye::makeStatement("SELECT * FROM `users`", []);

        //Make sure there is no result to start
        $this->assertEmpty($statement1->result());

        $statement2 = Wye::makeStatement("SELECT * FROM `apparatus`", []);

        //Make sure there is no result to start
        $this->assertEmpty($statement2->result());

        $result1 = Wye::makeResult()
            ->addRow(["id" => 1, "name" => "Test"])
            ->attach();

        $result2 = Wye::makeResult()
            ->addRow(["id" => 2, "name" => "Engine 1"])
            ->attach();


        Wye::executeStatement($statement1, []);

        $this->assertSame($result1, $statement1->result());

        Wye::executeStatement($statement2, []);

        $this->assertSame($result2, $statement2->result());
    }

    public function testNumQueriesIncremented()
    {
        $statement = Wye::makeStatement("SELECT * FROM `users`", []);

        for ($i = 0; $i < 3; $i++) {
            $this->assertSame($i, Wye::numQueries());
            Wye::executeStatement($statement, []);
        }
    }

    public function testTransactionPropertyNotSetWithoutTransaction()
    {
        $statement = Wye::makeStatement("test", []);

        Wye::executeStatement($statement);

        $this->assertAttributeSame(null, "transaction", $statement);
    }

    public function testTransactionPropertySetToCurrentTransaction()
    {
        $statement = Wye::makeStatement("test", []);

        Wye::beginTransaction();

        Wye::executeStatement($statement);

        $transaction = Wye::currentTransaction();

        $this->assertAttributeSame($transaction, "transaction", $statement);
    }
}