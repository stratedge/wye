<?php

namespace Tests\Unit\Collections\Collection;

use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class GetTest extends \Tests\TestCase
{
    public function testNotSetReturnsNull()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertNull($collection->get(4));
    }

    public function testNotSetReturnsDefault()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame('Engine', $collection->get(4, 'Engine'));
    }

    public function testReturnsValueAtKey()
    {
        $collection = new Collection(new Wye, [1, 2, 3]);

        $this->assertSame(2, $collection->get(1));

        $collection['Ladder'] = 'Rescue';

        $this->assertSame('Rescue', $collection->get('Ladder'));
    }
}
