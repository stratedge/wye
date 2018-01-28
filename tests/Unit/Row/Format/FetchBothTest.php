<?php

namespace Tests\Unit\Row\Format;

use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Wye;
use Tests\TestCase;

class FetchBothTest extends TestCase
{
    public function testReturnsArray()
    {
        $row = Wye::makeRow();

        $this->assertInternalType("array", $row->format(PDO::FETCH_BOTH));

        $row->data(["id" => 10, "apparatus" => "Engine 12"]);

        $this->assertInternalType("array", $row->format(PDO::FETCH_BOTH));
    }


    public function testReturnsDataProperlyFormatted()
    {
        $row = Wye::makeRow(["id" => 2, "apparatus" => "Squad 3"]);

        $data = $row->format(PDO::FETCH_BOTH);

        $expected = [
            "id" => 2,
            0 => 2,
            "apparatus" => "Squad 3",
            1 => "Squad 3"
        ];

        $this->assertSame($expected, $data);
    }


    public function testDataWithNumericalKeysReturnsOverwrittenData()
    {
        //Test shows why numerical keys are bad news
        $row = Wye::makeRow([4, "1" => "Quint 8"]);

        $data = $row->format(PDO::FETCH_BOTH);

        $expected = [
            0 => 4,
            "1" => "Quint 8",
            1 => "Quint 8"
        ];

        $this->assertSame($expected, $data);
    }
}
