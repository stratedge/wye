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

    /**
     * Create a new collection with only bindings with a parameter that matches
     * the provided parameter value.
     *
     * @param  int|string        $parameter
     * @return BindingCollection
     */
    public function filterByParameter($parameter)
    {
        $callback = function (Binding $binding, $key) use ($parameter) {
            return $binding->getParameter() == $parameter;
        };

        return $this->filter($callback);
    }

    /**
     * Rebuilds the contents of the collection based on the provided array. Keys
     * become binding parameters and values are used for binding values.
     * 0-indexed numerical-keyed arrays are shifted once to begin with 1.
     *
     * @param  array  $array
     * @return self
     */
    public function hydrateFromArray(array $array)
    {
        $this->clear();

        //If this is a 0-indexed numerical key array, add 1 to all the keys so
        //it is a 1-indexed numerical key array
        if (current(array_keys($array)) === 0) {
            $array = array_combine(
                range(1, count($array)),
                array_values($array)
            );
        }

        foreach ($array as $key => $value) {
            $this->push(
                $this->wye->makeBinding($key, $value)
            );
        }

        return $this;
    }
}
