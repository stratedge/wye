<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class LogBacktraceForTestTest extends \Tests\TestCase
{
    public function testTurnsBacktraceSingleOn()
    {
        $this->assertFalse(Wye::getBacktraceSingle());

        Wye::logBacktraceForTest();

        $this->assertTrue(Wye::getBacktraceSingle());
    }
}
