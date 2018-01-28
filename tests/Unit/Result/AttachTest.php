<?php

namespace Tests\Unit\Result;

use Stratedge\Wye\Wye;

class AttachTest extends \Tests\TestCase
{
    public function testAppendsResult()
    {
        $result = Wye::makeResult()->attach();
        $new_result = Wye::makeResult()->attach();

        $this->assertSame([$result, $new_result], Wye::getResults());
    }
}
