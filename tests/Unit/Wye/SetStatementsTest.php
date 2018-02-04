<?php

namespace Tests\Unit\Wye;

use Stratedge\Wye\Wye;

class SetStatementsTest extends \Tests\TestCase
{
    public function testSetsValue()
    {
        $collection = Wye::makeStatementCollection();

        $this->assertNotSame($collection, Wye::getStatements());

        Wye::setStatements($collection);

        $this->assertSame($collection, Wye::getStatements());
    }
}
