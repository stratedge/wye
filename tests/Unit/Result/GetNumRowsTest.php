<?php

namespace Tests\Unit\Result;

use Stratedge\Wye\Wye;

class GetNumRowsTest extends \Tests\TestCase
{
    public function testNullValueReturnsCount()
    {
        $result = Wye::makeResult()->addRows([
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
        ]);

        $this->assertSame(4, $result->getNumRows());
    }

    public function testReturnsPropertyValue()
    {
        $result = Wye::makeResult()->setNumRows(34645)
            ->addRows([
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ]);

        $this->assertSame(34645, $result->getNumRows());
    }

    public function testReturnsInteger()
    {
        $result = Wye::makeResult()->setNumRows('hello')
            ->addRows([
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
            ]);

        $this->assertSame(0, $result->getNumRows());
    }

    public function testReturnsZeroByDefault()
    {
        $result = Wye::makeResult();

        $this->assertSame(0, $result->getNumRows());
    }
}
