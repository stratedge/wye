<?php

namespace Stratedge\Wye;

use InvalidArgumentException;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Row;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

/**
 * @todo
 *   - Implement `fetch` method
 *   - Implement `fetchColumn` method
 *   - Implement `fetchObject` method
 *   - Implement `rowCount` method
 */
class Result
{
    use UsesWye;


    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var integer
     */
    protected $current_index = 0;

    /**
     * @var string|null
     */
    protected $last_insert_id;

    /**
     * @var int|null
     */
    protected $num_rows;

    /**
     * @var array
     */
    protected $rows = [];


    /**
     * @param Wye $wye
     */
    public function __construct(Wye $wye)
    {
        $this->wye($wye);
    }


    /**
     * Formats the next row according to the formatting parameters provided.
     *
     * @todo Handle when there are no more rows to get - return false?
     *
     * @param  integer $how
     * @param  integer $orientation
     * @param  integer $offset
     * @return mixed
     */
    public function fetch($how, $orientation, $offset)
    {
        $rows = $this->rows();

        if (!isset($rows[$this->current_index])) {
            return false;
        }

        $row = $rows[$this->current_index];

        $this->current_index++;

        return $row->format($how, $orientation, $offset);
    }


    /**
     * Formats and returns all the available rows in the result according to the
     * formatting parameters provided
     *
     * @param  integer $how        Integer value derived from PDO::FETCH_* constants
     * @param  string  $class_name Name of class to instantiate when PDO::FETCH_CLASS is used
     * @param  array   $ctor_args  Arguments to pass to constructor when PDO::FETCH_CLASS is used
     * @return array
     */
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
    // LAST INSERT ID
    //**************************************************************************

    public function lastInsertId($id = null)
    {
        if (is_null($id)) {
            return $this->getLastInsertId();
        } else {
            return $this->setLastInsertId($id);
        }
    }

    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }

    public function setLastInsertId($id)
    {
        $this->last_insert_id = (string) $id;
        return $this;
    }


    //**************************************************************************
    // NUM_ROWS
    //**************************************************************************

    /**
     * Retrieves the number of rows associated to the result. If the property is
     * not set, the count of $rows property will be returned.
     *
     * @return int
     */
    public function getNumRows()
    {
        if (is_null($this->num_rows)) {
            return count($this->rows);
        }

        return $this->num_rows;
    }

    /**
     * Set the number of row the result should return as having been selected or
     * affected.
     *
     * @param  int $num_rows
     * @return self
     */
    public function setNumRows($num_rows)
    {
        $this->num_rows = (int) $num_rows;

        return $this;
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
