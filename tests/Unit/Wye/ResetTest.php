<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class ResetTest extends TestCase
{
    public function testStatementsResetToEmptyArray()
    {
        $statement = Wye::makeStatement("test", []);

        $statement->execute();

        Wye::reset();

        $this->assertSame([], Wye::getStatements()->all());
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

    public function testBacktraceSingleResetToFalse()
    {
        Wye::logBacktraceForTest();

        $this->assertTrue(Wye::getBacktraceSingle());

        Wye::reset();

        $this->assertFalse(Wye::getBacktraceSingle());
    }

    public function testBacktraceAllNotResetToFalse()
    {
        Wye::logBacktraceForAllTests();

        $this->assertTrue(Wye::getBacktraceAll());

        Wye::reset();

        $this->assertTrue(Wye::getBacktraceAll());
    }

    public function testBacktraceLimitResetToNull()
    {
        Wye::setBacktraceLimit(12);

        $this->assertSame(12, Wye::getBacktraceLimit());

        Wye::reset();

        $this->assertNull(Wye::getBacktraceLimit());
    }

    public function testBacktraceDefaultLimitNotReset()
    {
        Wye::setBacktraceDefaultLimit(12);

        $this->assertSame(12, Wye::getBacktraceDefaultLimit());

        Wye::reset();

        $this->assertSame(12, Wye::getBacktraceDefaultLimit());
    }
}
