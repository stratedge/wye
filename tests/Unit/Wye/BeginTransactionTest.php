<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\PDO\PDOException;
use Stratedge\Wye\Transaction;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class BeginTransactionTest extends TestCase
{
    public function testTransactionTurnedOn()
    {
        Wye::beginTransaction();

        $this->assertAttributeSame(true, "in_transaction", Wye::class);
    }


    public function testExceptionThrownWhenAlreadyInTransaction()
    {
        $this->expectException(PDOException::class);

        Wye::beginTransaction();

        Wye::beginTransaction();
    }


    public function testSetsInTransactionToTrue()
    {
        Wye::beginTransaction();

        $this->assertAttributeSame(true, "in_transaction", Wye::class);
    }


    public function testAddsNewTransactionToTransactionsList()
    {
        Wye::beginTransaction();

        $transactions = Wye::getTransactions();

        $this->assertCount(1, $transactions);
        $this->assertInstanceOf(Transaction::class, $transactions[0]);
    }


    public function testIndexAssignedToNewTransaction()
    {
        Wye::beginTransaction();

        $transactions = Wye::getTransactions();

        $this->assertSame(0, $transactions[0]->getIndex());
    }
}
