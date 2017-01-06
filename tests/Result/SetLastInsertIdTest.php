<?php

namespace Tests\Result;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class SetLastInsertIdTest extends TestCase
{
    public function testReturnsSelf()
    {
        $result = Wye::makeResult();

        $this->assertSame($result, $result->setLastInsertId(7));
    }

    public function testSetsLastInserId()
    {
        $result = Wye::makeResult();

        $result->setLastInsertId('8');

        $this->assertAttributeSame('8', 'last_insert_id', $result);
    }

    public function testConvertsValueToString()
    {
        $result = Wye::makeResult();

        $result->setLastInsertId(145);

        $this->assertAttributeSame('145', 'last_insert_id', $result);
    }
}
