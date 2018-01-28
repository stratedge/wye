<?php

namespace Tests\Unit\Result;

use Stratedge\Wye\Wye;

class AttachAtIndexTest extends \Tests\TestCase
{
    public function testAppendsWithoutIndex()
    {
        $result = Wye::makeResult()->attach();
        $new_result = Wye::makeResult()->attachAtIndex();

        $this->assertSame([$result, $new_result], Wye::getResults());
    }

    public function testAddsResultAtIndex()
    {
        $result = Wye::makeResult()->attach();
        $new_result = Wye::makeResult()->attachAtIndex(3);

        $this->assertSame([0 => $result, 3 => $new_result], Wye::getResults());
    }

    public function testOverwritesResultAtIndex()
    {
        $result = Wye::makeResult()->attach();
        $new_result = Wye::makeResult()->attachAtIndex(0);

        $this->assertSame([$new_result], Wye::getResults());
    }
}
