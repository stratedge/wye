<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class ResetBacktraceDefaultLimitTest extends \Tests\TestCase
{
    public function testResetsDefaultLimit()
    {
        Wye::setBacktraceDefaultLimit(19);

        $this->assertSame(19, Wye::getBacktraceDefaultLimit());

        Wye::resetBacktraceDefaultLimit();

        $this->assertSame(0, Wye::getBacktraceDefaultLimit());
    }
}
