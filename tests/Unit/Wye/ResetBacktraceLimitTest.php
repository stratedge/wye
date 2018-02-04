<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ResetBacktraceLimitTest extends \Tests\TestCase
{
    public function testReturnsLimit()
    {
        Wye::setBacktraceLimit(19);

        $this->assertSame(19, Wye::getBacktraceLimit());

        Wye::resetBacktraceLimit();

        $this->assertNull(Wye::getBacktraceLimit());
    }
}
