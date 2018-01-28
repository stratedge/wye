<?php

namespace Tests\PDO\PDO;

use Stratedge\Wye\Wye;

class ExecTest extends \Tests\TestCase
{
    public function testReturnsZeroByDefault()
    {
        Wye::makeResult()->attach();

        $pdo = Wye::makePDO();

        $this->assertSame(0, $pdo->exec('DELETE FROM table_name'));
    }

    public function testReturnsNumRows()
    {
        Wye::makeResult()->setNumRows(12)->attach();

        $pdo = Wye::makePDO();

        $this->assertSame(12, $pdo->exec('DELETE FROM table_name'));
    }

    public function testRegistersStatement()
    {
        Wye::makeResult()->setNumRows(12)->attach();

        $pdo = Wye::makePDO();

        $pdo->exec('DELETE FROM table_name');

        $stmt = Wye::getStatementAtIndex(0);

        $this->assertSame('DELETE FROM table_name', $stmt->getStatement());
    }
}
