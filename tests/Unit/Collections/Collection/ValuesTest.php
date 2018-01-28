<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class ValuesTest extends \Tests\TestCase
{
    public function testReturnsNewOfSameType()
    {
        $collection = new Collection(new Wye);

        $result = $collection->values();

        $this->assertInstanceOf(get_class($collection), $result);
        $this->assertNotSame($collection, $result);
    }

    public function testReturnsJustValues()
    {
        $collection = new Collection(
            new Wye,
            ['apparatus' => 'Tanker 3', 'type' => 'Tender']
        );

        $result = $collection->values();

        $this->assertSame(['Tanker 3', 'Tender'], $result->all());
    }
}
