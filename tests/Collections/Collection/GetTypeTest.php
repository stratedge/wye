<?php

namespace Tests\Collections\Collection;

use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class GetTypeTest extends \Tests\TestCase
{
    public function testReturnsType()
    {
        $collection = new Collection(new Wye, []);

        $this->assertNull($collection->getType());

        foreach (['boolean', 'integer', 'double', 'string', 'stdClass'] as $value) {
            $collection = new Collection(new Wye, [], $value);
            $this->assertSame($value, $collection->getType());
        }
    }
}
