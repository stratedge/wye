<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ResetBacktraceForAllTests extends \Tests\TestCase
{
    public function testTurnsBacktraceAllOff()
    {
        Wye::logBacktraceForAllTests();

        $this->assertTrue(Wye::getBacktraceAll());

        Wye::resetBacktraceForAllTests();

        $this->assertFalse(Wye::getBacktraceAll());
    }
}
