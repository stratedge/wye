<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class GetOrCreateResultAtTest extends \Tests\TestCase
{
    public function testReturnsResultAtIndex()
    {
        $result = Wye::makeResult()->attach();

        $this->assertSame($result, Wye::getOrCreateResultAt(0));
    }

    public function testCreatesAndReturnsNewResult()
    {
        $result = Wye::makeResult()->attach();

        $this->assertCount(1, Wye::getResults());

        $new_result = Wye::getOrCreateResultAt(1);

        $this->assertCount(2, Wye::getResults());

        $this->assertSame([$result, $new_result], Wye::getResults());
    }
}
