<?php

namespace Tests\Unit\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class KeysTest extends \Tests\TestCase
{
    public function testReturnsNewOfSameType()
    {
        $collection = new Collection(new Wye);

        $result = $collection->keys();

        $this->assertInstanceOf(get_class($collection), $result);
        $this->assertNotSame($collection, $result);
    }

    public function testReturnsJustKeys()
    {
        $collection = new Collection(
            new Wye,
            ['apparatus' => 'Tanker 3', 'type' => 'Tender']
        );

        $result = $collection->keys();

        $this->assertSame(['apparatus', 'type'], $result->all());
    }
}
