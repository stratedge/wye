<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class GetBacktraceAllTest extends \Tests\TestCase
{
    public function testReturnsBacktraceAll()
    {
        $this->assertFalse(Wye::getBacktraceAll());

        Wye::logBacktraceForAllTests();

        $this->assertTrue(Wye::getBacktraceAll());
    }
}
