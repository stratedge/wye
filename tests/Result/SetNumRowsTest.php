<?php

namespace Tests\Result;

use Stratedge\Wye\Result;
use Stratedge\Wye\Wye;

class SetNumRowsTest extends \Tests\TestCase
{
    public function testReturnsSelf()
    {
        $result = Wye::makeResult();

        $this->assertSame($result, $result->setNumRows(123));
    }

    public function testSetsPropertyValue()
    {
        $result = new class (new Wye) extends Result {
            public $num_rows;
        };

        $result->setNumRows(56342);

        $this->assertSame(56342, $result->num_rows);
    }

    public function testSetsPropertyValueAsInteger()
    {
        $result = new class (new Wye) extends Result {
            public $num_rows;
        };

        $result->setNumRows('hello');

        $this->assertSame(0, $result->num_rows);
    }
}
