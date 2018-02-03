<?php

namespace Tests\Unit\PDO\PDOStatement;

use Stratedge\Wye\Wye;

class SetBacktraceTest extends \Tests\TestCase
{
    public function testSetsBacktraceValue()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $this->assertNull($stmt->getBacktrace());

        $collection = Wye::makeBacktraceCollection();

        $stmt->setBacktrace($collection);

        $this->assertSame($collection, $stmt->getBacktrace());
    }

    public function testReturnsSelf()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $collection = Wye::makeBacktraceCollection();

        $this->assertSame($stmt, $stmt->setBacktrace($collection));
    }
}
