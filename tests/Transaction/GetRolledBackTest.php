<?php

namespace Tests\Transaction;

use Stratedge\Wye\Wye;

class GetRolledBackTest extends \Tests\TestCase
{
    public function testReturnsPropertyValue()
    {
        $transaction = Wye::makeTransaction();

        $this->assertFalse($transaction->getRolledBack());

        $transaction->setRolledBack(true);

        $this->assertTrue($transaction->getRolledBack());
    }
}
