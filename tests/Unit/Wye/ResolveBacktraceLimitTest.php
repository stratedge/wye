<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ResolveBacktraceLimit extends \Tests\TestCase
{
    public function testNullLimitReturnsDefault()
    {
        Wye::setBacktraceDefaultLimit(12);

        $this->assertSame(12, Wye::resolveBacktraceLimit());
    }

    public function testLimitReturnLimit()
    {
        Wye::setBacktraceDefaultLimit(12);

        Wye::setBacktraceLimit(14);

        $this->assertSame(14, Wye::resolveBacktraceLimit());
    }
}
