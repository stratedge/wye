<?php

namespace Tests\Row\Format;

use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class FetchClassTest extends TestCase
{
    public function testReturnsStdClassObjectByDefault()
    {
        $row = Wye::makeRow(["id" => 1, "apparatus" => "Engine 1"]);

        $this->assertInstanceOf("stdClass", $row->format(PDO::FETCH_CLASS));
    }


    public function testReturnsObjectOfSpecifiedClass()
    {
        $row = Wye::makeRow(["id" => 1, "apparatus" => "Engine 1"]);

        $this->assertInstanceOf(self::class, $row->format(PDO::FETCH_CLASS, self::class));
    }


    public function testDataAddedToReturnedObject()
    {
        $row = Wye::makeRow(["id" => 2, "apparatus" => "Ladder 5"]);

        $obj = $row->format(PDO::FETCH_CLASS);

        $this->assertObjectHasAttribute("id", $obj);
        $this->assertObjectHasAttribute("apparatus", $obj);

        $this->assertAttributeSame(2, "id", $obj);
        $this->assertAttributeSame("Ladder 5", "apparatus", $obj);
    }
}
