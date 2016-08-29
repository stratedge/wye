<?php

namespace Stratedge\Wye\PDO;

use PDOStatement as BasePDOStatement;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Result;
use Stratedge\Wye\Traits\UsesWye;
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
 *   - Implement `execute` method
 *   - Implement `fetch` method
 *   - Implement `fetchColumn` method
 *   - Implement `fetchObject` method
 *   - Implement `getAttribute` method
 *   - Implement `getColumnMeta` method
 *   - Implement `nextRowset` method
 *   - Implement `rowCount` method
 *   - Implement `setAttribute` method
 *   - Implement `setFetchMode` method
 */
class PDOStatement extends BasePDOStatement
{
    use UsesWye;


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


    public function fetch($how = null, $orientation = null, $offset = null)
    {
        throw new Exception("PDOStatement::fetch() is not yet implemented by Wye.");
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
        return $this->result()->fetchAll($how, $class_name, $ctor_args);
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
}
