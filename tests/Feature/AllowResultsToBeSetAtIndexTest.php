<?php

namespace Tests\Feature;

use Stratedge\Wye\Wye;

class AllowResultsToBeSetAtIndexTest extends \Tests\TestCase
{
    public function testSetsAtIndex()
    {
        $result = Wye::makeResult()->attachAtIndex(3);

        $results = Wye::getResults();

        $this->assertSame([3 => $result], $results);
    }

    public function testOverwritesResult()
    {
        Wye::makeResult()->attach();
        $result = Wye::makeResult()->attachAtIndex(0);

        $results = Wye::getResults();

        $this->assertSame([0 => $result], $results);
    }
}
