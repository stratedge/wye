<?php

namespace Tests\PDO\PDO;

use Stratedge\Wye\Wye;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    public function testStringReturned()
    {
        $pdo = Wye::makePDO();

        $this->assertInternalType("string", $pdo->quote("testing"));
    }


    public function testStringContainsQuoteIndexReference()
    {
        $pdo = Wye::makePDO();

        $str = $pdo->quote("Report from Engine Company 82");

        $this->assertSame("<quote:0>Report from Engine Company 82</quote:0>", $str);

        $str = $pdo->quote($str);

        $this->assertSame("<quote:1><quote:0>Report from Engine Company 82</quote:0></quote:1>", $str);
    }


    public function testInvalidTypeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pdo = Wye::makePDO();

        $pdo->quote([]);
    }
}
