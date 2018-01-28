<?php

namespace Tests\Unit\Wye;

use PDOException;
use Stratedge\Wye\Wye;

class CommitTransactionTest extends \Tests\TestCase
{
    public function testNoTransactionThrowsException()
    {
        $this->setExpectedException(PDOException::class);
        Wye::commitTransaction();
    }

    public function testMarksTransactionCommitted()
    {
        Wye::beginTransaction();

        $transaction = Wye::currentTransaction();

        $this->assertFalse($transaction->getCommitted());

        Wye::commitTransaction();

        $this->assertTrue($transaction->getCommitted());
    }

    public function testSetsInTransactionToFalse()
    {
        $this->assertFalse(Wye::getInTransaction());

        Wye::beginTransaction();

        $this->assertTrue(Wye::getInTransaction());

        Wye::commitTransaction();

        $this->assertFalse(Wye::getInTransaction());
    }
}
