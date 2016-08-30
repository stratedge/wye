<?php

namespace Tests\Wye;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class ResetTest extends TestCase
{
    public function testStatementsResetToEmptyArray()
    {
        $statement = Wye::makeStatement("test", []);

        $statement->execute();

        Wye::reset();

        $this->assertAttributeSame([], "statements", Wye::class);
    }


    public function testResultsResetToEmptyArray()
    {
        Wye::makeResult()
            ->attach();

        Wye::reset();

        $this->assertAttributeSame([], "results", Wye::class);
    }


    public function testNumQueriesResetToZero()
    {
        Wye::makeStatement("test", [])
            ->execute();

        Wye::reset();

        $this->assertAttributeSame(0, "num_queries", Wye::class);
    }


    public function testQuotesResetToEmptyArray()
    {
        $pdo = Wye::makePDO();

        $pdo->quote("test");

        Wye::reset();

        $this->assertAttributeSame([], "quotes", Wye::class);
    }


    public function testInTransactionResetToFalse()
    {
        Wye::beginTransaction();

        Wye::reset();

        $this->assertAttributeSame(false, "in_transaction", Wye::class);
    }


    public function testTransactionsResetToEmptyArray()
    {
        Wye::beginTransaction();

        Wye::reset();

        $this->assertAttributeSame([], "transactions", Wye::class);
    }
}
