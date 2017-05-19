<?php

namespace Stratedge\Wye\Collections;

interface BindingCollectionInterface extends CollectionInterface
{
    /**
     * Create a new collection with only bindings with a given data type.
     *
     * @param  int               $data_type
     * @return BindingCollection
     */
    public function filterByDataType($data_type);

    /**
     * Create a new collection with only bindings with a parameter that matches
     * the provided parameter value.
     *
     * @param  int|string        $parameter
     * @return BindingCollection
     */
    public function filterByParameter($parameter);

    /**
     * Create a new collection with only bindings with a value that matches the
     * provided value.
     *
     * @param  mixed             $value
     * @return BindingCollection
     */
    public function filterByValue($value);

    /**
     * Create a new collection with only bindings with a value that contain the
     * provided value.
     *
     * @param  mixed             $value
     * @return BindingCollection
     */
    public function filterByValueLike($value);

    /**
     * Determines if the given data type is used by any of the bindings
     * contained in the collection.
     *
     * @param  int     $data_type
     * @return boolean
     */
    public function hasDataType($data_type);

    /**
     * Determines if the given parameter exists in any of the bindings in the
     * collection.
     *
     * @param  int|string  $parameter
     * @return boolean
     */
    public function hasParameter($parameter);

    /**
     * Determines if the given value exists in any of the bindings in the
     * collection.
     *
     * @param  mixed   $value
     * @return boolean
     */
    public function hasValue($value);

    /**
     * Determines if the given value is contained in any values in any of the
     * bindings in the collection.
     *
     * @param  mixed   $value
     * @return boolean
     */
    public function hasValueLike($value);

    /**
     * Rebuilds the contents of the collection based on the provided array. Keys
     * become binding parameters and values are used for binding values.
     * 0-indexed numerical-keyed arrays are shifted once to begin with 1.
     *
     * @param  array  $array
     * @return self
     */
    public function hydrateFromArray(array $array);
}
