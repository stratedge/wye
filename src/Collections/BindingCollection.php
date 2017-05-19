<?php

namespace Stratedge\Wye\Collections;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Wye;

class BindingCollection extends Collection implements BindingCollectionInterface
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
     * Create a new collection with only bindings with a given data type.
     *
     * @param  int $data_type
     * @return BindingCollectionInterface
     */
    public function filterByDataType($data_type)
    {
        $callback = function (Binding $binding, $key) use ($data_type) {
            switch ($data_type) {
                case PDO::PARAM_BOOL:
                    return $binding->isBoolean();
                case PDO::PARAM_NULL:
                    return $binding->isNull();
                case PDO::PARAM_INT:
                    return $binding->isInteger();
                case PDO::PARAM_STR:
                    return $binding->isString();
                case PDO::PARAM_LOB:
                    return $binding->isLargeObject();
                case PDO::PARAM_STMT:
                    return $binding->isStatement();
                case PDO::PARAM_INPUT_OUTPUT:
                    return $binding->isInputOutput();
            }
        };

        return $this->filter($callback);
    }

    /**
     * Create a new collection with only bindings with a parameter that matches
     * the provided parameter value.
     *
     * @param  int|string $parameter
     * @return BindingCollectionInterface
     */
    public function filterByParameter($parameter)
    {
        $callback = function (Binding $binding, $key) use ($parameter) {
            return $binding->getParameter() == $parameter;
        };

        return $this->filter($callback);
    }

    /**
     * Create a new collection with only bindings with a value that matches the
     * provided value.
     *
     * @param  mixed $value
     * @return BindingCollectionInterface
     */
    public function filterByValue($value)
    {
        $callback = function (Binding $binding, $key) use ($value) {
            return $binding->getValue() == $value;
        };

        return $this->filter($callback);
    }

    /**
     * Create a new collection with only bindings with a value that contain the
     * provided value.
     *
     * @param  mixed $value
     * @return BindingCollectionInterface
     */
    public function filterByValueLike($value)
    {
        $callback = function (Binding $binding, $key) use ($value) {
            return strpos($binding->getValue(), $value) !== false;
        };

        return $this->filter($callback);
    }

    /**
     * Determines if the given data type is used by any of the bindings
     * contained in the collection.
     *
     * @param  int     $data_type
     * @return boolean
     */
    public function hasDataType($data_type)
    {
        return $this->filterByDataType($data_type)->isNotEmpty();
    }

    /**
     * Determines if the given parameter exists in any of the bindings in the
     * collection.
     *
     * @param  int|string  $parameter
     * @return boolean
     */
    public function hasParameter($parameter)
    {
        return $this->filterByParameter($parameter)->isNotEmpty();
    }

    /**
     * Determines if the given value exists in any of the bindings in the
     * collection.
     *
     * @param  mixed   $value
     * @return boolean
     */
    public function hasValue($value)
    {
        return $this->filterByValue($value)->isNotEmpty();
    }

    /**
     * Determines if the given value is contained in any values in any of the
     * bindings in the collection.
     *
     * @param  mixed   $value
     * @return boolean
     */
    public function hasValueLike($value)
    {
        return $this->filterByValueLike($value)->isNotEmpty();
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
