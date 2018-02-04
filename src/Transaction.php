<?php

namespace Stratedge\Wye;

use Stratedge\Wye\PDO\PDOStatement;

class Transaction
{
    /**
     * @var index
     */
    protected $index;

    /**
     * @var boolean
     */
    protected $committed = false;

    /**
     * @var boolean
     */
    protected $rolled_back = false;

    /**
     * @var array
     */
    protected $statements = [];


    public function __construct($index = null)
    {
        if (!is_null($index)) {
            $this->setIndex($index);
        }
    }


    //**************************************************************************
    // INDEX
    //**************************************************************************

    /**
     * @deprecated
     */
    public function index($index = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        if (is_null($index)) {
            return $this->getIndex();
        } else {
            return $this->setIndex($index);
        }
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = (int) $index;
    }



    //**************************************************************************
    // COMMITTED
    //**************************************************************************

    /**
     * @deprecated
     */
    public function committed($committed = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        if (is_null($committed)) {
            return $this->getCommitted();
        } else {
            return $this->setCommitted($committed);
        }
    }

    public function getCommitted()
    {
        return $this->committed;
    }

    public function setCommitted($committed)
    {
        $this->committed = (bool) $committed;
    }


    //**************************************************************************
    // ROLLED_BACK
    //**************************************************************************

    /**
     * Returns the value of the rolled_back property.
     *
     * @return boolean
     */
    public function getRolledBack()
    {
        return $this->rolled_back;
    }

    /**
     * Sets the value of the rolled_back property.
     *
     * @param boolean $rolled_back
     */
    public function setRolledBack($rolled_back)
    {
        $this->rolled_back = (bool) $rolled_back;
    }



    //**************************************************************************
    // STATEMENTS
    //**************************************************************************

    /**
     * @deprecated
     */
    public function statements(array $statements = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        if (is_null($statements)) {
            return $this->getStatements();
        } else {
            return $this->setStatements($statements);
        }
    }

    public function getStatements()
    {
        return $this->statements;
    }

    public function setStatements(array $statements)
    {
        $this->statement = $statements;
    }

    public function addStatement(PDOStatement $statement)
    {
        //Add this transation to the statement
        $statement->setTransaction($this);

        $this->statements[] = $statement;
    }
}
