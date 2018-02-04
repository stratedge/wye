<?php

namespace Tests\Unit\PDO\PDO;

use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class PrepareTest extends TestCase
{
    public function testReturnsStatement()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`");

        $this->assertInstanceOf(PDOStatement::class, $statement);
    }


    public function testReturnedStatementHasWyeSet()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`");

        $this->assertInstanceOf(Wye::class, $statement->getWye());
    }


    public function testReturnedStatementHasStatementSet()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`");

        $this->assertSame("SELECT * FROM `users`", $statement->getStatement());
    }


    public function testReturnedStatementHasOptionsSet()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`", ["test" => true]);

        $this->assertSame(["test" => true], $statement->getOptions());
    }
}
