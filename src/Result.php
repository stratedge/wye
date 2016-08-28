<?php

namespace Stratedge\Wye;

use InvalidArgumentException;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Row;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

class Result
{
    use UsesWye;


    /**
     * @var array
     */
    protected $columns = [];


    /**
     * @var array
     */
    protected $rows = [];


    public function __construct(Wye $wye)
    {
        $this->wye($wye);
    }


    public function fetchAll($how, $class_name, $ctor_args)
    {
        $result = [];

        foreach ($this->rows() as $row) {
            $result[] = $row->format($how, $class_name, $ctor_args);
        }

        return $result;
    }


    //**************************************************************************
    // COLUMNS
    //**************************************************************************

    public function columns($columns = null)
    {
        if (is_null($columns)) {
            return $this->getColumns();
        } else {
            if (!is_array($columns)) {
                $columns = func_get_args();
            }

            return $this->setColumns($columns);
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setColumns(array $columns)
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }

        $this->columns = $columns;

        return $this;
    }

    public function hasColumns()
    {
        return empty($this->columns) === false;
    }

    public function getColumnAtIndex($index = 0)
    {
        $columns = $this->columns();
        return isset($columns[$index]) ? $columns[$index] : null;
    }

    public function countColumns()
    {
        return count($this->columns());
    }



    //**************************************************************************
    // ROWS
    //**************************************************************************

    public function rows($rows = null)
    {
        if (is_null($rows)) {
            return $this->getRows();
        } else {
            return $this->setRows($rows);
        }
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    public function addRow($row)
    {
        if ($row instanceof Row === false) {
            if (!is_array($row)) {
                $tmp_row = func_get_args();

                if ($this->hasColumns() === true) {
                    if (count($tmp_row) !== $this->countColumns()) {
                        throw new InvalidArgumentException("Invalid number of values provided.");
                    }

                    $row = [];

                    foreach ($tmp_row as $key => $value) {
                        $row[$this->getColumnAtIndex($key)] = $value;
                    }
                } else {
                    $row = $tmp_row;
                }
            }

            $row = $this->wye()->makeRow($row);
        }

        $this->rows[] = $row;

        return $this;
    }

    public function addRows(array $rows)
    {
        if (func_num_args() > 1) {
            $rows = func_get_args();
        }

        foreach ($rows as $row) {
            $this->addRow($row);
        }

        return $this;
    }

    public function attach()
    {
        $this->wye()->addResult($this);
        return $this;
    }
}
