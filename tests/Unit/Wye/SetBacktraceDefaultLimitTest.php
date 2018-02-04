<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class SetBacktraceDefaultLimitTest extends \Tests\TestCase
{
    public function testSetsDefaultLimit()
    {
        Wye::setBacktraceDefaultLimit(19);

        $this->assertSame(19, Wye::getBacktraceDefaultLimit());
    }
}
