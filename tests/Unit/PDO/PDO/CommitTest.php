<?php

namespace Tests\Unit\PDO\PDO;

use PDOException;
use Stratedge\Wye\Wye;

class CommitTest extends \Tests\TestCase
{
    public function testNoTransactionThrowsException()
    {
        $this->setExpectedException(PDOException::class);

        Wye::makePDO()->commit();
    }

    public function testMarksLastTransactionCommitted()
    {
        $pdo = Wye::makePDO();

        $pdo->beginTransaction();

        $transaction = Wye::currentTransaction();

        $this->assertFalse($transaction->getCommitted());

        $pdo->commit();

        $this->assertTrue($transaction->getCommitted());
    }

    public function testReturnsTrue()
    {
        $pdo = Wye::makePDO();

        $pdo->beginTransaction();

        $this->assertTrue($pdo->commit());
    }

    public function testMarksWyeNoLongerInTransaction()
    {
        $pdo = Wye::makePDO();

        $this->assertFalse(Wye::getInTransaction());

        $pdo->beginTransaction();

        $this->assertTrue(Wye::getInTransaction());

        $pdo->commit();

        $this->assertFalse(Wye::getInTransaction());
    }
}
