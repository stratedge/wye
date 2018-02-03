<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ResetBacktraceForTestTest extends \Tests\TestCase
{
    public function testTurnsBacktraceSingleOff()
    {
        Wye::logBacktraceForTest();

        $this->assertTrue(Wye::getBacktraceSingle());

        Wye::resetBacktraceForTest();

        $this->assertFalse(Wye::getBacktraceSingle());
    }
}
