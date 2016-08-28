<?php

namespace Tests\PDO\PDOStatement;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class ExecuteTest extends TestCase
{
    public function testReturnsTrue()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertTrue($statement->execute());
    }


    public function testParamsSetOnStatement()
    {
        $statement = Wye::makeStatement("", []);

        //Make sure the default is an empty array
        $this->assertSame([], $statement->params());

        $statement->execute(["testing" => true]);

        $this->assertSame(["testing" => true], $statement->params());
    }


    public function testResultSetOnStatement()
    {
        $statement = Wye::makeStatement("", []);

        //Make sure the default is null
        $this->assertNull($statement->result());

        $result = Wye::makeResult()
            ->attach();

        $statement->execute();

        $this->assertSame($result, $statement->result());
    }
}
