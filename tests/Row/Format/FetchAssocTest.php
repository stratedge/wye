<?php

namespace Tests\Row\Format;

use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class FetchAssocTest extends TestCase
{
    public function testReturnsArray()
    {
        $row = Wye::makeRow();

        $this->assertInternalType("array", $row->format(PDO::FETCH_ASSOC));

        $row->data(["id" => 1, "apparatus" => "Ladder 7"]);

        $this->assertInternalType("array", $row->format(PDO::FETCH_ASSOC));
    }


    public function testReturnsArrayWithColumnsAsKeys()
    {
        $row = Wye::makeRow(["id" => 4, "apparatus" => "Rescue 2"]);

        $data = $row->format(PDO::FETCH_ASSOC);

        $this->assertArrayHasKey("id", $data);
        $this->assertArrayHasKey("apparatus", $data);
    }
}
