<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class LogBacktraceForAllTestsTest extends \Tests\TestCase
{
    public function testTurnsBacktraceAllOn()
    {
        $this->assertFalse(Wye::getBacktraceAll());

        Wye::logBacktraceForAllTests();

        $this->assertTrue(Wye::getBacktraceAll());
    }
}
