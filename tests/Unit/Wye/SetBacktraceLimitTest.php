<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class SetBacktraceLimitTest extends \Tests\TestCase
{
    public function testSetsLimit()
    {
        Wye::setBacktraceLimit(19);

        $this->assertSame(19, Wye::getBacktraceLimit());
    }
}
