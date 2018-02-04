<?php

namespace Stratedge\Wye\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

interface CollectionInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Retrieve the value of the type property.
     *
     * @return string|null
     */
    public function getType();

    /**
     * Sets an array as the content of the collection.
     *
     * @param  array $items
     * @return self
     */
    public function setItems(array $items);

    /**
     * Retrieve the contents of the collection as an array.
     *
     * @return array
     */
    public function all();

    /**
     * Empties the collection.
     *
     * @return self
     */
    public function clear();

    /**
     * Create a new collection containing the items of the original collection
     * that pass the given callback. When no callback is provided, falsey values
     * are removed.
     *
     * @param  callable|null $callback
     * @return Collection
     */
    public function filter(callable $callback = null);

    /**
     * Retrieve the first item in the collection, or the first item that matches
     * the criteria defined in a function. When matching by a function, a
     * default value may be set if no results are found.
     *
     * @param  callable|null $callback Optional callback to match items on.
     * @param  mixed|null    $default  Returned if a callback fails to match any items.
     * @return mixed
     */
    public function first(callable $callback = null, $default = null);

    /**
     * Retrieve an item at a key or offset.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Determines if the collection is empty.
     *
     * @return boolean
     */
    public function isEmpty();

    /**
     * Determines if the collection is not empty.
     *
     * @return boolean
     */
    public function isNotEmpty();

    /**
     * Return a new collection where the items are the keys from the original
     * collection.
     *
     * @return Collection
     */
    public function keys();

    /**
     * Retrieve the last item in the collection, or the last item that matches
     * the criteria defined in a function. When matching by a function, a
     * default value may be set if no results are found.
     *
     * @param  callable|null $callback Optional callback to match items on.
     * @param  mixed|null    $default  Returned if a callback fails to match any items.
     * @return mixed
     */
    public function last(callable $callback = null, $default = null);

    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback);

    /**
     * Remove the last item in the collection and return it.
     *
     * @return mixed
     */
    public function pop();

    /**
     * Appends one or more values to the end of the collection's items.
     *
     * @param  mixed $values
     * @return self
     */
    public function push(...$values);

    /**
     * Remove the first item in the collection and return it.
     *
     * @return mixed
     */
    public function shift();

    /**
     * Appends one or more values to the beginning of the collection's items.
     *
     * @param  mixed $values
     * @return self
     */
    public function unshift(...$values);

    /**
     * Return a new collection with the same item values but the keys converted
     * to consecutive integers.
     *
     * @return Collection
     */
    public function values();

    /**
     * Determine if the collection has an item set at an offset.
     *
     * @param  int|string $offset
     * @return boolean
     */
    public function offsetExists($offset);

    /**
     * Retrieve an item at an offset.
     *
     * @param  int|string $offset
     * @return mixed
     */
    public function offsetGet($offset);

    /**
     * Set an item at an offset.
     *
     * @param  int|string $offset
     * @param  mixed      $value
     */
    public function offsetSet($offset, $value);

    /**
     * Unset an item in the collection at an offset.
     *
     * @param  int|string $offset
     */
    public function offsetUnset($offset);

    /**
     * Retrieve the total number of items in the collection.
     *
     * @return int
     */
    public function count();

    /**
     * Retrieve an interator so the items can be iterated over.
     *
     * @return ArrayIterator
     */
    public function getIterator();
}
