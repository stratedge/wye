<?php

namespace Tests\Unit\PDO\PDOStatement;

use Stratedge\Wye\Wye;

class GetBacktraceTest extends \Tests\TestCase
{
    public function testReturnsBacktraceValue()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $this->assertNull($stmt->getBacktrace());

        $collection = Wye::makeBacktraceCollection();

        $stmt->setBacktrace($collection);

        $this->assertSame($collection, $stmt->getBacktrace());
    }
}
