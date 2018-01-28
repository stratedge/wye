<?php

namespace Tests\Feature;

use Stratedge\Wye\Wye;

class AllowQueriesWithoutResultsTest extends \Tests\TestCase
{
    public function testQueryWithoutResultsSucceeds()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();

        $this->assertSame([], $stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function testMultipleQueriesWithoutResultsSucceeds()
    {
        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();

        $this->assertSame([], $stmt->fetchAll(\PDO::FETCH_ASSOC));

        $stmt = Wye::makeStatement('INSERT INTO table_name (col) VALUES ("test")', []);

        $stmt->execute();

        $this->assertSame(0, $stmt->rowCount());
    }

    public function testMissingResultsInMiddleSucceeds()
    {
        Wye::makeResult()->addRow(['id' => 12])->attach();
        Wye::makeResult()->setNumRows(14)->attachAtIndex(2);

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();

        $this->assertSame([['id' => 12]], $stmt->fetchAll(\PDO::FETCH_ASSOC));

        $stmt = Wye::makeStatement('SELECT * FROM table_name', []);

        $stmt->execute();

        $this->assertSame([], $stmt->fetchAll(\PDO::FETCH_ASSOC));

        $stmt = Wye::makeStatement('INSERT INTO table_name (col) VALUES ("test")', []);

        $stmt->execute();

        $this->assertSame(14, $stmt->rowCount());
    }
}
