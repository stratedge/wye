<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\Wye;

class GetLastStatementTest extends \Tests\TestCase
{
    public function testRetrievesLatestStatement()
    {
        $stmt1 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt3 = Wye::makeStatement('SELECT * FROM table_name', []);

        $this->assertNull(Wye::getLastStatement());

        Wye::addStatement($stmt1);

        $this->assertSame($stmt1, Wye::getLastStatement());

        Wye::addStatement($stmt2);

        $this->assertSame($stmt2, Wye::getLastStatement());

        Wye::addStatement($stmt3);

        $this->assertSame($stmt3, Wye::getLastStatement());
    }
}
