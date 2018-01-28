<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class AddResultAtIndexTest extends \Tests\TestCase
{
    public function testAddsResultToSpecificIndex()
    {
        $result = Wye::makeResult()->attachAtIndex(2);

        $this->assertSame([2 => $result], Wye::getResults());
    }

    public function testOverwritesResultAtSpecificIndex()
    {
        $result = Wye::makeResult()->attach();

        $this->assertSame([$result], Wye::getResults());

        $new_result = Wye::makeResult()->attachAtIndex(0);

        $this->assertSame([$new_result], Wye::getResults());
    }
}
