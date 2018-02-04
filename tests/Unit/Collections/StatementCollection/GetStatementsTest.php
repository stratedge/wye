<?php

namespace Tests\Unit\Collections\StatementCollection;

use Stratedge\Wye\Collections\CollectionInterface;
use Stratedge\Wye\Wye;

class GetStatementsTest extends \Tests\TestCase
{
    public function testReturnsNewCollection()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt->execute();

        $collection = Wye::getStatements();

        $new = $collection->getStatements();

        $this->assertNotSame($new, $collection);
        $this->assertInstanceOf(CollectionInterface::class, $new);
    }

    public function testCollectionContainsStatements()
    {
        $stmt1 = Wye::makeStatement('SELECT * FROM table_name', []);
        $stmt1->execute();

        $stmt2 = Wye::makeStatement('UPDATE table_name', []);
        $stmt2->execute();

        $stmt3 = Wye::makeStatement('DELETE FROM table_name', []);
        $stmt3->execute();

        $collection = Wye::getStatements();

        $new = $collection->getStatements();

        $this->assertCount(3, $new);
        $this->assertSame('SELECT * FROM table_name', $new->get(0));
        $this->assertSame('UPDATE table_name', $new->get(1));
        $this->assertSame('DELETE FROM table_name', $new->get(2));
    }
}
