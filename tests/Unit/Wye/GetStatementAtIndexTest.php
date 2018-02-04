<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\Wye;

class GetStatementAtIndexTest extends \Tests\TestCase
{
    public function testGetCorrectStatement()
    {
        $stmt1 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt3 = Wye::makeStatement('SELECT * FROM table_name', []);

        Wye::addStatement($stmt1);
        Wye::addStatement($stmt2);
        Wye::addStatement($stmt3);

        $this->assertSame($stmt1, Wye::getStatementAtIndex(0));
        $this->assertSame($stmt2, Wye::getStatementAtIndex(1));
        $this->assertSame($stmt3, Wye::getStatementAtIndex(2));
        $this->assertNull(Wye::getStatementAtIndex(3));
    }
}
