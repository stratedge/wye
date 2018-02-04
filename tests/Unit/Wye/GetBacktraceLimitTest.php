<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class GetBacktraceLimitTest extends \Tests\TestCase
{
    public function testReturnsLimit()
    {
        $this->assertNull(Wye::getBacktraceLimit());

        Wye::setBacktraceLimit(19);

        $this->assertSame(19, Wye::getBacktraceLimit());
    }
}
