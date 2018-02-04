<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\Wye;

class GetStatementsTest extends \Tests\TestCase
{
    public function testReturnsNewCollectionIfNoneExists()
    {
        $collection = Wye::getStatements();

        $this->assertInstanceOf(StatementCollectionInterface::class, $collection);
    }

    public function testReturnsCollection()
    {
        $collection = Wye::makeStatementCollection();

        Wye::setStatements($collection);

        $this->assertSame($collection, Wye::getStatements());
    }
}
