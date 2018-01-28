<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;
use Stratedge\Wye\Result;
use Tests\TestCase;

class MakeResultTest extends TestCase
{
    public function testReturnsResult()
    {
        $result = Wye::makeResult();

        $this->assertInstanceOf(Result::class, $result);
    }


    public function testSetsWyePropertyOnResult()
    {
        $result = Wye::makeResult();

        $this->assertInstanceOf(Wye::class, $result->wye());
    }
}
