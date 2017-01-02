<?php

namespace Tests\Row\Format;

use stdClass;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class FetchObjTest extends TestCase
{
    public function testReturnsStdClass()
    {
        $row = Wye::makeRow();

        $this->assertInstanceOf(stdClass::class, $row->format(PDO::FETCH_OBJ));

        $row->data(["id" => 1, "apparatus" => "Ladder 7"]);

        $this->assertInstanceOf(stdClass::class, $row->format(PDO::FETCH_OBJ));
    }


    public function testReturnsStdClassWithColumnsAsProperties()
    {
        $row = Wye::makeRow(["id" => 4, "apparatus" => "Rescue 2"]);

        $data = $row->format(PDO::FETCH_OBJ);

        $this->assertObjectHasAttribute("id", $data);
        $this->assertObjectHasAttribute("apparatus", $data);
    }
}
