<?php

namespace Tests\Transaction;

use Stratedge\Wye\Wye;

class SetRolledBackTest extends \Tests\TestCase
{
    public function testSetsPropertyValue()
    {
        $transaction = Wye::makeTransaction();

        $this->assertFalse($transaction->getRolledBack());

        $transaction->setRolledBack(true);

        $this->assertTrue($transaction->getRolledBack());

        $transaction->setRolledBack(false);

        $this->assertFalse($transaction->getRolledBack());
    }
}
