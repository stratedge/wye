<?php

namespace Tests\PDO\PDO;

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

        $this->assertInstanceOf(Wye::class, $statement->wye());
    }


    public function testReturnedStatementHasStatementSet()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`");

        $this->assertSame("SELECT * FROM `users`", $statement->statement());
    }


    public function testReturnedStatementHasOptionsSet()
    {
        $pdo = Wye::makePDO();

        $statement = $pdo->prepare("SELECT * FROM `users`", ["test" => true]);

        $this->assertSame(["test" => true], $statement->options());
    }
}
