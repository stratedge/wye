<?php

namespace Tests\PDO\PDOStatement\Fetch;

use Stratedge\Wye\Wye;
use Stratedge\Wye\PDO\PDO;
use Tests\TestCase;

class FetchAssocTest extends TestCase
{
    public function testFetchesArray()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $this->assertInternalType('array', $statement->fetch(PDO::FETCH_ASSOC));
    }

    public function testReturnsAssocArrayWithColumnsForKeys()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertArrayHasKey('id', $row);
        $this->assertArrayHasKey('apparatus', $row);
    }

    public function testReturnsAssocArrayWithValues()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertSame($row['id'], 7);
        $this->assertSame($row['apparatus'], 'Engine 2');
    }

    public function testReturnsNextRows()
    {
        Wye::makeResult()->addRows([
            ['id' => 7, 'apparatus' => 'Engine 2'],
            ['id' => 8, 'apparatus' => 'Ladder 5'],
        ])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertSame($row['id'], 7);
        $this->assertSame($row['apparatus'], 'Engine 2');

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertSame($row['id'], 8);
        $this->assertSame($row['apparatus'], 'Ladder 5');
    }
}
