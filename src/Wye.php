<?php

namespace Stratedge\Wye;

use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Result;
use Stratedge\Wye\Row;

class Wye
{
    /**
     * @var boolean
     */
    protected static $booted = false;

    /**
     * @var array
     */
    protected static $statements = [];

    /**
     * @var array
     */
    protected static $results = [];

    /**
     * @var int
     */
    protected static $num_queries = 0;


    public function __construct()
    {
        if ($this->isBooted()) {
            $this->boot();
        }
    }


    public static function boot()
    {
        static::reset();
    }


    public static function reset()
    {
        static::resetStatements();
        static::resetResults();
        static::resetNumQueries();
    }


    public static function makeStatement($statement, $options)
    {
        $statement = new PDOStatement(new static, $statement, $options);
        return $statement;
    }


    public static function makePDO()
    {
        $pdo = new PDO(new static);
        return $pdo;
    }


    public static function makeResult()
    {
        $result = new Result(new static);
        return $result;
    }


    public static function makeRow(array $data)
    {
        $row = new Row(new static, $data);
        return $row;
    }


    public static function executeStatement(
        PDOStatement $statement,
        array $params = []
    ) {
        //Add the statement to the list of those run
        static::addStatement($statement);

        //Add params to the statement
        $statement->params($params);

        $result = static::getResultAt(static::numQueries());

        //Add the result to the statement
        $statement->result($result);

        //Increment number of queries run
        static::incrementNumQueries();
    }



    //**************************************************************************
    // BOOTED
    //**************************************************************************

    public static function booted($booted = null)
    {
        if (is_null($is_booted)) {
            return static::getBooted();
        } else {
            return static::setBooted($booted);
        }
    }

    public static function getBooted()
    {
        return static::$booted;
    }

    public static function setBooted($booted)
    {
        static::$booted = (bool) $booted;
    }

    public static function isBooted()
    {
        return static::getBooted() === true;
    }



    //**************************************************************************
    // STATEMENTS
    //**************************************************************************

    public static function statements($statements = null)
    {
        if (is_null($statements)) {
            return static::getStatements();
        } else {
            return static::setStatements($statements);
        }
    }

    public static function getStatements()
    {
        return static::$statements;
    }

    public static function setStatements($statements)
    {
        static::$statements = $statements;
    }

    public static function resetStatements()
    {
        static::setStatements([]);
    }

    public static function addStatement(PDOStatement $statement)
    {
        //Add statement
        $statements = static::statements();
        $statements[] = $statement;

        //Store statements
        static::statements($statements);
    }

    public static function getStatementAtIndex($index = 0)
    {
        $statements = static::statements();

        return isset($statements[$index]) ? $statements[$index] : null;
    }



    //**************************************************************************
    // RESULTS
    //**************************************************************************

    public static function results($results = null)
    {
        if (is_null($results)) {
            return static::getResults();
        } else {
            return static::setResults($results);
        }
    }

    public static function getResults()
    {
        return static::$results;
    }

    public static function getResultAt($index = 0)
    {
        $results = static::results();

        return !empty($results[$index]) ? $results[$index] : null;
    }

    public static function setResults($results)
    {
        static::$results = $results;
    }

    public static function resetResults()
    {
        static::setResults([]);
    }

    public static function addResult($result)
    {
        //Add result
        $results = static::results();
        $results[] = $result;

        //Store results
        static::results($results);
    }



    //**************************************************************************
    // NUM_QUERIES
    //**************************************************************************

    public static function numQueries($num_queries = null)
    {
        if (is_null($num_queries)) {
            return static::getNumQueries();
        } else {
            return static::setNumQueries($num_queries);
        }
    }

    public static function getNumQueries()
    {
        return static::$num_queries;
    }

    public static function setNumQueries($num_queries)
    {
        static::$num_queries = $num_queries;
    }

    public function resetNumQueries()
    {
        static::setNumQueries(0);
    }

    public static function incrementNumQueries()
    {
        $num_queries = static::numQueries();
        static::numQueries($num_queries++);
    }
}
