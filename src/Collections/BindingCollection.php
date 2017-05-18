<?php

namespace Stratedge\Wye\Collections;

use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class BindingCollection extends Collection
{
    /**
     * Create a new instance of BindingCollection.
     *
     * @param Wye   $wye
     * @param array $items
     */
    public function __construct(Wye $wye, $items = [])
    {
        parent::__construct($wye, $items, Binding::class);
    }
}
