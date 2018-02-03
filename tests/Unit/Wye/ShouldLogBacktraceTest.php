<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ShouldLogBacktraceTest extends \Tests\TestCase
{
    public function testReturnsFalseIfBothFalse()
    {
        $this->assertFalse(Wye::shouldLogBacktrace());
    }

    public function testReturnsTrueForBacktraceAllOn()
    {
        Wye::logBacktraceForAllTests();

        $this->assertTrue(Wye::shouldLogBacktrace());
    }

    public function testReturnsTrueForBacktraceSingleOn()
    {
        Wye::logBacktraceForTest();

        $this->assertTrue(Wye::shouldLogBacktrace());
    }
}
