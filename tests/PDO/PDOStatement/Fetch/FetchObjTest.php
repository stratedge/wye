<?php

namespace Tests\PDO\PDOStatement\Fetch;

use stdClass;
use Stratedge\Wye\Wye;
use Stratedge\Wye\PDO\PDO;
use Tests\TestCase;

class FetchObjTest extends TestCase
{
    public function testFetchesClass()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $this->assertInstanceOf(
            stdClass::class,
            $statement->fetch(PDO::FETCH_OBJ)
        );
    }

    public function testReturnsClassWithProperties()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_OBJ);

        $this->assertObjectHasAttribute('id', $row);
        $this->assertObjectHasAttribute('apparatus', $row);
    }

    public function testReturnsClassWithValues()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_OBJ);

        $this->assertSame($row->id, 7);
        $this->assertSame($row->apparatus, 'Engine 2');
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

        $row = $statement->fetch(PDO::FETCH_OBJ);

        $this->assertSame($row->id, 7);
        $this->assertSame($row->apparatus, 'Engine 2');

        $row = $statement->fetch(PDO::FETCH_OBJ);

        $this->assertSame($row->id, 8);
        $this->assertSame($row->apparatus, 'Ladder 5');
    }
}
