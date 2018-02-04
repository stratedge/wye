<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\Wye;

class ResetStatementsTest extends \Tests\TestCase
{
    public function testResetsValueToCollection()
    {
        $collection = Wye::makeStatementCollection();

        $this->assertNotSame($collection, Wye::getStatements());

        Wye::setStatements($collection);

        $this->assertSame($collection, Wye::getStatements());

        Wye::resetStatements();

        $this->assertNotSame($collection, Wye::getStatements());
        $this->assertInstanceOf(StatementCollectionInterface::class, Wye::getStatements());
    }
}
