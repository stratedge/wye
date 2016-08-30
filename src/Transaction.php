<?php

namespace Stratedge\Wye;

class Transaction
{
    /**
     * @var index
     */
    protected $index;

    /**
     * @var committed
     */
    protected $committed = false;

    /**
     * @var array
     */
    protected $statements = [];


    public function __construct(int $index = null)
    {
        if (!is_null($index)) {
            $this->setIndex($index);
        }
    }


    //**************************************************************************
    // INDEX
    //**************************************************************************

    public function index(int $index = null)
    {
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

    public function setIndex(int $index)
    {
        $this->index = (int) $index;
    }



    //**************************************************************************
    // COMMITTED
    //**************************************************************************

    public function committed(bool $committed = null)
    {
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

    public function setCommitted(bool $committed)
    {
        $this->committed = (bool) $committed;
    }



    //**************************************************************************
    // STATEMENTS
    //**************************************************************************

    public function statements(array $statements = null)
    {
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
        $this->statements[] = $statement;
    }
}
