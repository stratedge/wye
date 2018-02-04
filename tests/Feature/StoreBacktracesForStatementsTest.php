<?php

namespace Tests\Feature;

use Stratedge\Wye\Collections\BacktraceCollectionInterface;
use Stratedge\Wye\Wye;

class StoreBacktracesForStatementsTest extends \Tests\TestCase
{
    public function testTurnedOffStoresNoBacktraces()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();

        $this->assertNull($stmt->getBacktrace());
    }

    public function testOnForAllTestsStoresBacktrace()
    {
        Wye::logBacktraceForAllTests();

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();
        $stmt2->execute();

        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt->getBacktrace());
        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt2->getBacktrace());
    }

    public function testOnForTestStoresBacktrace()
    {
        Wye::logBacktraceForTest();

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();
        $stmt2->execute();

        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt->getBacktrace());
        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt2->getBacktrace());
    }

    public function testOnForAllTestsSpansResets()
    {
        Wye::logBacktraceForAllTests();

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();
        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt->getBacktrace());

        Wye::reset();

        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2->execute();
        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt2->getBacktrace());
    }

    public function testOnForOneTestDoesNotSpanResets()
    {
        Wye::logBacktraceForTest();

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();
        $this->assertInstanceOf(BacktraceCollectionInterface::class, $stmt->getBacktrace());

        Wye::reset();

        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2->execute();
        $this->assertNull($stmt2->getBacktrace());
    }

    public function testBacktraceDefaultLimitAppliedIfNeeded()
    {
        Wye::logBacktraceForTest();
        Wye::setBacktraceDefaultLimit(3);

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();

        $this->assertCount(3, $stmt->getBacktrace());
    }

    public function testPerTestBacktraceLimitApplied()
    {
        Wye::logBacktraceForTest();
        Wye::setBacktraceDefaultLimit(3);
        Wye::setBacktraceLimit(2);

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();

        $this->assertCount(2, $stmt->getBacktrace());
    }

    public function testBacktraceDefaultLimitSpansResets()
    {
        Wye::logBacktraceForAllTests();
        Wye::setBacktraceDefaultLimit(3);

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();
        $this->assertCount(3, $stmt->getBacktrace());

        Wye::reset();

        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2->execute();
        $this->assertCount(3, $stmt2->getBacktrace());
    }

    public function testBacktraceLimitDoesNotSpanResets()
    {
        Wye::logBacktraceForAllTests();
        Wye::setBacktraceDefaultLimit(3);
        Wye::setBacktraceLimit(2);

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();
        $this->assertCount(2, $stmt->getBacktrace());

        Wye::reset();

        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2->execute();
        $this->assertCount(3, $stmt2->getBacktrace());
    }
}
