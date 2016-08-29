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


    public function __construct(Wye $wye, array $data = null)
    {
        $this->wye($wye);

        if (!is_null($data)) {
            $this->data($data);
        }
    }


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


    protected function formatAssoc()
    {
        return $this->data();
    }


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
