<?php

namespace Tests\Unit\Wye;

use PDOException;
use Stratedge\Wye\Wye;

class RollBackTransactionTest extends \Tests\TestCase
{
    public function testNoTransactionThrowsException()
    {
        $this->setExpectedException(PDOException::class);
        Wye::rollBackTransaction();
    }

    public function testMarksTransactionRolledBack()
    {
        Wye::beginTransaction();

        $transaction = Wye::currentTransaction();

        $this->assertFalse($transaction->getRolledBack());

        Wye::rollBackTransaction();

        $this->assertTrue($transaction->getRolledBack());
    }

    public function testSetsInTransactionToFalse()
    {
        $this->assertFalse(Wye::getInTransaction());

        Wye::beginTransaction();

        $this->assertTrue(Wye::getInTransaction());

        Wye::rollBackTransaction();

        $this->assertFalse(Wye::getInTransaction());
    }
}
