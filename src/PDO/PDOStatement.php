<?php

namespace Stratedge\Wye\PDO;

use PDOStatement as BasePDOStatement;
use RuntimeException;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Result;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Transaction;
use Stratedge\Wye\Wye;

/**
 * @todo
 *   - Implement `bindColumn` method
 *   - Implement `bindParam` method
 *   - Implement `bindValue` method
 *   - Implement `closeCursor` method
 *   - Implement `columnCount` method
 *   - Implement `debugDumpParams` method
 *   - Implement `errorCode` method
 *   - Implement `errorInfo` method
 *   - Finish `execute` method
 *   - Finish `fetch` method
 *   - Implement `fetchColumn` method
 *   - Implement `getAttribute` method
 *   - Implement `getColumnMeta` method
 *   - Implement `nextRowset` method
 *   - Implement `setAttribute` method
 */
class PDOStatement extends BasePDOStatement
{
    use UsesWye;

    /**
     * @var BindingCollection
     */
    protected $bindings;

    /**
     * @var string
     */
    protected $statement;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var Result
     */
    protected $result;

    /**
     * @var array
     */
    protected $fetch_mode = [PDO::ATTR_DEFAULT_FETCH_MODE];

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @param Wye    $wye
     * @param string $statement
     * @param array  $options
     */
    public function __construct(Wye $wye, $statement, $options)
    {
        $this->wye($wye);
        $this->statement($statement);
        $this->options($options);
    }



    //**************************************************************************
    // PDOSTATEMENT METHODS
    //**************************************************************************

    /**
     * Mimic for PDOStatement::execute(). Records the statement execution and
     * returns true.
     *
     * @todo This method should be optionally set to return false to mimic errors
     *
     * @param  array  $params Column binding parameters
     * @return true
     */
    public function execute($params = [])
    {
        $this->wye()->executeStatement($this, $params);
        return true;
    }


    /**
     * Mimic for PDOStatement::fetch(). Retrieves a single row from the result
     * set consistent with the fetch method given.
     *
     * @todo Implement the orientation parameter
     *
     * @param  integer|null $how
     * @param  mixed        $orientation
     * @param  mixed        $offset
     * @return mixed
     */
    public function fetch($how = null, $orientation = null, $offset = null)
    {
        if (is_null($how)) {
            $defaults = $this->fetchMode();

            $how = $defaults[0];
            $orientation = !empty($defaults[1]) ? $defaults[1] : null;
            $offset = !empty($defaults[2]) ? $defaults[2] : null;
        }

        return $this->result()->fetch($how, $orientation, $offset);
    }


    /**
     * Mimic for PDOStatement::fetchAll(). Returns output formatted according to
     * options provided
     *
     * @param  int    $how        Integer value derived from PDO::FETCH_* constants
     * @param  string $class_name Name of class to instantiate when PDO::FETCH_CLASS is used
     * @param  array  $ctor_args  Arguments to provide to class constructor when PDO::FETCH_CLASS is used
     * @return mixed
     */
    public function fetchAll($how = null, $class_name = null, $ctor_args = null)
    {
        if (is_null($how)) {
            $defaults = $this->fetchMode();

            $how = $defaults[0];
            $class_name = !empty($defaults[1]) ? $defaults[1] : null;
            $ctor_args = !empty($defaults[2]) ? $defaults[2] : null;
        }

        return $this->result()->fetchAll($how, $class_name, $ctor_args);
    }


    /**
     * Mimic for PDOStatement::fetchObject(). Returns the next row as an
     * instance of the given class with properties corresponding to the result
     * columns.
     *
     * @param  string $class_name
     * @param  array  $ctor_args
     * @return object
     */
    public function fetchObject($class_name = 'stdClass', $ctor_args = [])
    {
        return $this->fetch(PDO::FETCH_CLASS, $class_name, $ctor_args);
    }


    /**
     * Mimic for PDOStatement::setFetchMode(). Sets the default fetch mode and
     * associated options
     *
     * @param int   $mode      Integer value derived from PDO::FETCH_* constants
     * @param mixed $params    Additional params dependent on fetch mode
     * @param mixed $ctor_args Additional params dependent on fetch mode
     */
    public function setFetchMode($mode, $params = null, $ctor_args = null)
    {
        $this->fetch_mode = array_slice(func_get_args(), 0, 3);
        return true;
    }


    /**
     * Mimic for PDOStatement::rowCount(). Returns the number of rows associated
     * with the result of the statement execution.
     *
     * @return int
     */
    public function rowCount()
    {
        if (is_null($this->result)) {
            throw new RuntimeException('Call to PDOStatement::rowCount with no associated Result.');
        }

        return $this->result->getNumRows();
    }



    //**************************************************************************
    // STATEMENT
    //**************************************************************************

    public function statement($statement = null)
    {
        if (is_null($statement)) {
            return $this->getStatement();
        } else {
            return $this->setStatement($statement);
        }
    }

    public function getStatement()
    {
        return $this->statement;
    }

    public function setStatement($statement)
    {
        $this->statement = $statement;
        return $this;
    }



    //**************************************************************************
    // OPTIONS
    //**************************************************************************

    public function options($options = null)
    {
        if (is_null($options)) {
            return $this->getOptions();
        } else {
            return $this->setOptions($options);
        }
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }



    //**************************************************************************
    // PARAMS
    //**************************************************************************

    public function params($params = null)
    {
        if (is_null($params)) {
            return $this->getParams();
        } else {
            return $this->setParams($params);
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }



    //**************************************************************************
    // RESULT
    //**************************************************************************

    public function result($result = null)
    {
        if (is_null($result)) {
            return $this->getResult();
        } else {
            return $this->setResult($result);
        }
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult(Result $result)
    {
        $this->result = $result;
        return $this;
    }



    //**************************************************************************
    // FETCH_MODE
    //**************************************************************************

    public function fetchMode(array $fetch_mode = null)
    {
        if (is_null($fetch_mode)) {
            return $this->getFetchMode();
        } else {
            return $this->setFetchMode($fetch_mode);
        }
    }

    public function getFetchMode()
    {
        return $this->fetch_mode;
    }


    //**************************************************************************
    // TRANSACTION
    //**************************************************************************

    public function transaction(Transaction $transaction = null)
    {
        if (is_null($transaction)) {
            return $this->getTransaction();
        } else {
            return $this->setTransaction($transaction);
        }
    }

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
