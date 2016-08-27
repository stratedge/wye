<?php

namespace Stratedge\Wye\PDO;

use PDOStatement as BasePDOStatement;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\Result;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

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


    public function __construct(Wye $wye, $statement, $options)
    {
        $this->wye($wye);
        $this->statement($statement);
        $this->options($options);
    }


    public function execute($params = [])
    {
        $this->wye()->executeStatement($this, $params);
        return true;
    }


    public function fetch($how = null, $orientation = null, $offset = null)
    {
        ddd("fetch");
    }


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
