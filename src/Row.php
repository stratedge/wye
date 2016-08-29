<?php

namespace Stratedge\Wye;

use Exception;
use ReflectionClass;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Traits\UsesWye;

class Row
{
    use UsesWye;


    /**
     * @var array
     */
    protected $data = [];


    /**
     * @param Wye        $wye
     * @param array|null $data
     */
    public function __construct(Wye $wye, array $data = null)
    {
        $this->wye($wye);

        if (!is_null($data)) {
            $this->data($data);
        }
    }


    /**
     * Formats and returns the row's data according to the formatting options
     * specified
     *
     * @param  int    $how        An integer constructed from PDO::FETCH_* constant values
     * @param  string $class_name Used in conjunction with PDO::FETCH_CLASS
     * @param  array  $ctor_args  Used in conjunction with PDO::FETCH_CLASS
     * @return mixed
     */
    public function format($how, $class_name = "stdClass", $ctor_args = [])
    {
        /**
         * @todo:
         *     - Implement PDO::FETCH_CLASSTYPE flag on PDO::FETCH_CLASS
         *     - Implement PDO::FETCH_PROPS_LATE flag on PDO::FETCH_CLASS
         *     - Implement PDO::FETCH_BOUND
         *     - Implement PDO::FETCH_INTO
         *     - Implement PDO::FETCH_LAZY
         *     - Implement PDO::FETCH_NAMED
         *     - Implement PDO::FETCH_NUM
         *     - Implement PDO::FETCH_OBJ
         */

        switch ($how) {
            case PDO::FETCH_ASSOC:
                $data = $this->formatAssoc();
                break;
            case PDO::FETCH_BOTH:
                $data = $this->formatBoth();
                break;
            case PDO::FETCH_CLASS:
                $data = $this->formatClass($class_name, $ctor_args);
                break;
            default:
                throw new Exception("Need to implement formatter for $how");
        }

        return $data;
    }


    /**
     * Formats and returns the row's data as an associative array
     *
     * @return array
     */
    protected function formatAssoc()
    {
        return $this->data();
    }


    /**
     * Formats and returns the row's data as a single array with each column
     * repeated - once with a string key describing the column name, and once
     * with an integer key representing the column's numerical position.
     *
     * @return array
     */
    protected function formatBoth()
    {
        $data = [];
        $index = 0;

        foreach ($this->data() as $key => $value) {
            $data[$key] = $value;
            $data[$index] = $value;
            $index++;
        }

        return $data;
    }


    /**
     * Formats and returns the row's data as an object of the type specified by
     * $class_name.
     *
     * @param  string $class_name Name of the class to instantiate
     * @param  array $ctor_args   Array of arguments to pass to object's constructor
     * @return object
     */
    protected function formatClass($class_name, $ctor_args)
    {
        $r = new ReflectionClass($class_name);
        $data = $r->newInstanceArgs((array) $ctor_args);

        foreach ($this->data() as $key => $value) {
            $data->$key = $value;
        }

        return $data;
    }


    //**************************************************************************
    // DATA
    //**************************************************************************

    public function data(array $data = null)
    {
        if (is_null($data)) {
            return $this->getData();
        } else {
            return $this->setData($data);
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}
