<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;
use Stratedge\Wye\Row;
use Tests\TestCase;

class MakeRowTest extends TestCase
{
    public function testReturnsRow()
    {
        $row = Wye::makeRow([]);

        $this->assertInstanceOf(Row::class, $row);
    }


    public function testSetsWyePropertyOnRow()
    {
        $row = Wye::makeRow([]);

        $this->assertInstanceOf(Wye::class, $row->getWye());
    }


    public function testSetsDataPropertyOnRow()
    {
        $row = Wye::makeRow(["id" => 1, "apparatus" => "Engine 1"]);

        $this->assertSame(["id" => 1, "apparatus" => "Engine 1"], $row->getData());
    }
}
