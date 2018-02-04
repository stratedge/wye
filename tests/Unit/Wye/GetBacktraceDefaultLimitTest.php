<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class GetBacktraceDefaultLimitTest extends \Tests\TestCase
{
    public function testReturnsDefaultLimit()
    {
        $this->assertSame(0, Wye::getBacktraceDefaultLimit());

        Wye::setBacktraceDefaultLimit(19);

        $this->assertSame(19, Wye::getBacktraceDefaultLimit());
    }
}
