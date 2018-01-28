<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class MakeStatementTest extends TestCase
{
    public function testReturnsStatement()
    {
        $statement = Wye::makeStatement("testing", []);

        $this->assertInstanceOf(PDOStatement::class, $statement);
    }


    public function testSetsWyePropertyOnStatement()
    {
        $statement = Wye::makeStatement("testing", []);

        $this->assertInstanceOf(Wye::class, $statement->wye());
    }


    public function testSetsStatementPropertyOnStatement()
    {
        $statement = Wye::makeStatement("SELECT * FROM `users`", []);

        $this->assertSame("SELECT * FROM `users`", $statement->statement());
    }


    public function testSetsOptionsPropertyOnStatement()
    {
        $statement = Wye::makeStatement("testing", ["key" => "value"]);

        $this->assertSame(["key" => "value"], $statement->options());
    }
}
