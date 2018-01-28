<?php

namespace Tests\Unit\Collections\BindingCollection;

use Stratedge\Wye\BindingInterface;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class MetaTest extends \Tests\TestCase
{
    public function testSetsTypeToBinding()
    {
        $collection = new BindingCollection(new Wye);

        $this->assertSame(BindingInterface::class, $collection->getType());
    }
}
