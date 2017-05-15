<?php

namespace Stratedge\Wye\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;
use Traversable;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    use UsesWye;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * The type constraint for the values the collection may contain. Valid
     * values include null, any value returned by gettype(), or a fully
     * qualified class name. By default type is null and no constraints are
     * placed on item type.
     *
     *
     * @var string|null
     */
    protected $type;

    /**
     * Create a new instance of Collection.
     *
     * @param Wye         $wye
     * @param array       $items
     * @param string|null $type  What type of items the collection will hold.
     *     Either a value returned by gettype() or a fully qualified class name.
     */
    public function __construct(Wye $wye, $items = [], $type = null)
    {
        $this->setWye($wye);

        $this->type = $type;

        $this->setItems($items);
    }

    /**
     * Retrieve the value of the type property.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets an array as the content of the collection.
     *
     * @param  array $items
     * @return self
     */
    public function setItems(array $items)
    {
        $items = $this->getArrayableItems($items);

        foreach ($items as $item) {
            //Ensure the correct type is provided
            $this->checkType($item);
        }

        $this->items = $items;

        return $this;
    }

    //**************************************************************************
    // COLLECTION HELPERS
    //**************************************************************************

    /**
     * Retrieve the contents of the collection as an array.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Retrieve the first item in the collection, or the first item that matches
     * the criteria defined in a function. When matching by a function, a
     * default value may be set if no results are found.
     *
     * @param  callable|null $callback Optional callback to match items on.
     * @param  mixed|null    $default  Returned if a callback fails to match any items.
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($this->items)) {
                return null;
            }

            foreach ($this->items as $value) {
                return $value;
            }
        }

        foreach ($this->items as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Retrieve an item at a key or offset.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        return $default;
    }

    /**
     * Determines if the collection is empty or not.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Retrieve the last item in the collection, or the last item that matches
     * the criteria defined in a function. When matching by a function, a
     * default value may be set if no results are found.
     *
     * @param  callable|null $callback Optional callback to match items on.
     * @param  mixed|null    $default  Returned if a callback fails to match any items.
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        $items = array_reverse($this->items);

        if (is_null($callback)) {
            if (empty($items)) {
                return null;
            }

            foreach ($items as $value) {
                return $value;
            }
        }

        foreach ($items as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Remove the last item in the collection and return it.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Appends one or more values to the end of the collection's items.
     *
     * @param  mixed $values
     * @return self
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->offsetSet(null, $value);
        }

        return $this;
    }

    /**
     * Remove the first item in the collection and return it.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Appends one or more values to the beginning of the collection's items.
     *
     * @param  mixed $values
     * @return self
     */
    public function unshift(...$values)
    {
        foreach ($values as $value) {
            //Ensure the correct type is provided
            $this->checkType($value);
        }

        array_unshift($this->items, ...$values);

        return $this;
    }

    //**************************************************************************
    // ARRAY ACCESS
    //**************************************************************************

    /**
     * Determine if the collection has an item set at an offset.
     *
     * @param  int|string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Retrieve an item at an offset.
     *
     * @param  int|string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->items[$offset];
        }
    }

    /**
     * Set an item at an offset.
     *
     * @param  int|string $offset
     * @param  mixed      $value
     */
    public function offsetSet($offset, $value)
    {
        //Ensure the correct type is provided
        $this->checkType($value);

        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Unset an item in the collection at an offset.
     *
     * @param  int|string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    //**************************************************************************
    // COUNTABLE
    //**************************************************************************

    /**
     * Retrieve the total number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    //**************************************************************************
    // ITERATOR AGGREGATOR
    //**************************************************************************

    /**
     * Retrieve an interator so the items can be iterated over.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    //**************************************************************************
    // INTERNAL METHODS
    //**************************************************************************

    /**
     * Checks an item to ensure it of the correct type and throws an exception
     * if the type is invalid.
     *
     * @param  mixed   $item
     * @return boolean
     *
     * @throws InvalidArgumentException
     */
    protected function checkType($item)
    {
        if ($this->isCorrectType($item) === false) {
            $error = sprintf(
                '%s may contain only values of type %s, %s given.',
                get_class($this),
                $this->type,
                is_object($item) ? get_class($item) : gettype($item)
            );

            throw new InvalidArgumentException($error);
        }

        return true;
    }

    /**
     * Convert input into an array.
     *
     * @param  mixed $items
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        }

        if ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }

    /**
     * Checks if an item is the correct type as set for the collection.
     *
     * @param  mixed   $item
     * @return boolean
     */
    protected function isCorrectType($item)
    {
        if (is_null($this->type)) {
            return true;
        }

        if ($this->type !== 'object' && is_object($item)) {
            return $item instanceof $this->type;
        }

        return gettype($item) === $this->type;
    }
}
