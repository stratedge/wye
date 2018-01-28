<?php

namespace Tests\Unit\PDO\PDO;

use Stratedge\Wye\PDO\PDOException;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class BeginTransactionTest extends TestCase
{
    public function testReturnsTrue()
    {
        $pdo = Wye::makePDO();

        $this->assertTrue($pdo->beginTransaction());
    }


    public function testExceptionThrownWhenAlreadyInTransaction()
    {
        $this->expectException(PDOException::class);

        $pdo = Wye::makePDO();

        $pdo->beginTransaction();

        $pdo->beginTransaction();
    }
}
