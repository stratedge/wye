<?php

namespace Tests\PDO\PDO;

use PDOException;
use Stratedge\Wye\Wye;

class RollBackTest extends \Tests\TestCase
{
    public function testNoTransactionThrowsException()
    {
        $this->setExpectedException(PDOException::class);

        Wye::makePDO()->rollBack();
    }

    public function testMarksLastTransactionRolledBack()
    {
        $pdo = Wye::makePDO();

        $pdo->beginTransaction();

        $transaction = Wye::currentTransaction();

        $this->assertFalse($transaction->getRolledBack());

        $pdo->rollBack();

        $this->assertTrue($transaction->getRolledBack());
    }

    public function testReturnsTrue()
    {
        $pdo = Wye::makePDO();

        $pdo->beginTransaction();

        $this->assertTrue($pdo->rollBack());
    }

    public function testMarksWyeNoLongerInTransaction()
    {
        $pdo = Wye::makePDO();

        $this->assertFalse(Wye::getInTransaction());

        $pdo->beginTransaction();

        $this->assertTrue(Wye::getInTransaction());

        $pdo->rollBack();

        $this->assertFalse(Wye::getInTransaction());
    }
}
