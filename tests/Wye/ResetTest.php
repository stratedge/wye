<?php

namespace Tests\Wye;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class ResetTest extends TestCase
{
    public function testStatementsResetToEmptyArray()
    {
        $statement = Wye::makeStatement("test", []);

        $statement->execute();

        Wye::reset();

        $this->assertAttributeSame([], "statements", Wye::class);
    }


    public function testResultsResetToEmptyArray()
    {
        Wye::makeResult()
            ->attach();

        Wye::reset();

        $this->assertAttributeSame([], "results", Wye::class);
    }


    public function testNumQueriesResetToZero()
    {
        Wye::makeStatement("test", [])
            ->execute();

        Wye::reset();

        $this->assertAttributeSame(0, "num_queries", Wye::class);
    }
}
