<?php

namespace Tests\PDO\PDOStatement\Fetch;

use stdClass;
use Stratedge\Wye\Wye;
use Stratedge\Wye\PDO\PDO;
use Tests\Objects\TestConstructorArgsPassed;
use Tests\TestCase;

class FetchClassTest extends TestCase
{
    public function testFetchesClass()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $this->assertInstanceOf(
            stdClass::class,
            $statement->fetch(PDO::FETCH_CLASS, stdClass::class)
        );
    }

    public function testReturnsClassWithProperties()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_CLASS, stdClass::class);

        $this->assertObjectHasAttribute('id', $row);
        $this->assertObjectHasAttribute('apparatus', $row);
    }

    public function testReturnsClassWithValues()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_CLASS, stdClass::class);

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

        $row = $statement->fetch(PDO::FETCH_CLASS, stdClass::class);

        $this->assertSame($row->id, 7);
        $this->assertSame($row->apparatus, 'Engine 2');

        $row = $statement->fetch(PDO::FETCH_CLASS, stdClass::class);

        $this->assertSame($row->id, 8);
        $this->assertSame($row->apparatus, 'Ladder 5');
    }

    public function testConstructorArgumentsArePassed()
    {
        Wye::makeResult()->addRow(['id' => 7, 'apparatus' => 'Engine 2'])->attach();

        $pdo = Wye::makePDO();

        $statement = $pdo->prepare('SELECT *');
        $statement->execute();

        $row = $statement->fetch(
            PDO::FETCH_CLASS,
            TestConstructorArgsPassed::class,
            ['first', 'second']
        );

        $this->assertInstanceOf(TestConstructorArgsPassed::class, $row);

        $this->assertObjectHasAttribute('first', $row);
        $this->assertObjectHasAttribute('second', $row);

        $this->assertSame('first', $row->first);
        $this->assertSame('second', $row->second);
    }
}
