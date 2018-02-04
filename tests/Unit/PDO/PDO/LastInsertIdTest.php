<?php

namespace Tests\Unit\PDO\PDO;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class LastInsertIdTest extends TestCase
{
    public function testReturnsGivenValueAsString()
    {
        $pdo = Wye::makePDO();

        $result = Wye::makeResult();
        $result->setLastInsertId(5);
        $result->attach();

        $statement = $pdo->prepare('INSERT INTO apparatus');
        $statement->execute();

        $this->assertSame('5', $pdo->lastInsertId());
    }

    public function testReturnsNullByDefault()
    {
        $pdo = Wye::makePDO();

        $result = Wye::makeResult()->attach();

        $statement = $pdo->prepare('INSERT INTO apparatus');
        $statement->execute();

        $this->assertNull($pdo->lastInsertId());
    }
}
