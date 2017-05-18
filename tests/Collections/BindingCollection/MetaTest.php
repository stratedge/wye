<?php

namespace Tests\Collections\BindingCollection;

use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class MetaTest extends \Tests\TestCase
{
    public function testSetsTypeToBinding()
    {
        $collection = new BindingCollection(new Wye);

        $this->assertSame(Binding::class, $collection->getType());
    }
}
