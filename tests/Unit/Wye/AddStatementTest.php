<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\Wye;

class AddStatementTest extends \Tests\TestCase
{
    public function testAddsStatementToCollection()
    {
        $stmt1 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt2 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt3 = Wye::makeStatement('SELECT * FROM table_name', []);

        $this->assertCount(0, Wye::getStatements());

        Wye::addStatement($stmt1);

        $this->assertCount(1, Wye::getStatements());
        $this->assertSame($stmt1, Wye::getStatements()->get(0));

        Wye::addStatement($stmt2);

        $this->assertCount(2, Wye::getStatements());
        $this->assertSame($stmt1, Wye::getStatements()->get(0));
        $this->assertSame($stmt2, Wye::getStatements()->get(1));

        Wye::addStatement($stmt3);

        $this->assertCount(3, Wye::getStatements());
        $this->assertSame($stmt1, Wye::getStatements()->get(0));
        $this->assertSame($stmt2, Wye::getStatements()->get(1));
        $this->assertSame($stmt3, Wye::getStatements()->get(2));
    }
}
