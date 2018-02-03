<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class GetBacktraceSingleTest extends \Tests\TestCase
{
    public function testReturnsBacktraceSingle()
    {
        $this->assertFalse(Wye::getBacktraceSingle());

        Wye::logBacktraceForTest();

        $this->assertTrue(Wye::getBacktraceSingle());
    }
}
