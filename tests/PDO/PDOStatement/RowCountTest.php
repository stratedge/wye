<?php

namespace Tests\PDO\PDOStatement;

use Stratedge\Wye\Result;
use Stratedge\Wye\Wye;

class RowCountTest extends \Tests\TestCase
{
    public function testNoResultThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Call to PDOStatement::rowCount with no associated Result.');

        $stmt = Wye::makeStatement(null, null);

        $stmt->rowCount();
    }

    public function testReturnsResultNumRows()
    {
        $stmt = Wye::makeStatement(null, null);

        $result = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->setMethods(['getNumRows'])
            ->getMock();

        $result->expects($this->once())
            ->method('getNumRows')
            ->willReturn(547);

        $stmt->setResult($result);

        $this->assertSame(547, $stmt->rowCount());
    }
}
