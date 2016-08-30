<?php

namespace Stratedge\Wye;

use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Result;
use Stratedge\Wye\Row;

class Wye
{
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

    /**
     * @var array
     */
    protected static $quotes = [];

    /**
     * @var bool
     */
    protected static $in_transaction = false;


    /**
     * Resets all the static properties so that a new test can be run with fresh
     * information
     *
     * @return void
     */
    public static function reset()
    {
        static::resetStatements();
        static::resetResults();
        static::resetNumQueries();
        static::resetQuotes();
    }


    /**
     * Creates and returns a new Stratedge\Wye\PDO\PDOStatement object
     *
     * @param  string $statement The SQL statement that would be executed
     * @param  array  $options   An array of options for statement execution
     * @return PDOStatement
     */
    public static function makeStatement($statement, $options)
    {
        $statement = new PDOStatement(new static, $statement, $options);
        return $statement;
    }


    /**
     * Creates and returns a new Stratedge\Wye\PDO\PDO object
     *
     * @return PDO
     */
    public static function makePDO()
    {
        $pdo = new PDO(new static);
        return $pdo;
    }


    /**
     * Creates and a returns a new Stratedge\Wye\Result object
     *
     * @return Result
     */
    public static function makeResult()
    {
        $result = new Result(new static);
        return $result;
    }


    /**
     * Creates and returns a new Stratedge\Wye\Row object
     *
     * @param  array  $data Associative array of row data
     * @return Row
     */
    public static function makeRow(array $data = [])
    {
        $row = new Row(new static, $data);
        return $row;
    }


    /**
     * Records a simulation of a query execution
     *
     * @param  PDOStatement $statement
     * @param  array        $params
     * @return void
     */
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


    public static function quote($string, $param_type = null)
    {
        $data = [
            "string" => $string,
            "param_type" => $param_type
        ];

        $num_quotes = static::getNumQuotes();

        static::addQuote($data);

        return sprintf(
            "<quote:%d>%s</quote:%d>",
            $num_quotes,
            $string,
            $num_quotes
        );
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

    public static function resetNumQueries()
    {
        static::setNumQueries(0);
    }

    public static function incrementNumQueries()
    {
        $num_queries = static::numQueries();
        $num_queries++;

        static::numQueries($num_queries);
    }



    //**************************************************************************
    // QUOTES
    //**************************************************************************

    public static function quotes($quotes = null)
    {
        if (is_null($quotes)) {
            return static::getQuotes();
        } else {
            return static::setQuotes($quotes);
        }
    }

    public static function getQuotes()
    {
        return static::$quotes;
    }

    public static function setQuotes(array $quotes = [])
    {
        static::$quotes = $quotes;
    }

    public static function addQuote(array $quote)
    {
        $quotes = static::getQuotes();
        $quotes[] = $quote;

        static::setQuotes($quotes);
    }

    public static function getNumQuotes()
    {
        return count(static::getQuotes());
    }

    public static function resetQuotes()
    {
        static::setQuotes([]);
    }



    //**************************************************************************
    // IN TRANSACTION
    //**************************************************************************

    public static function inTransaction(bool $in_transaction = null)
    {
        if (is_null($in_transaction)) {
            return static::getInTransaction();
        } else {
            return static::setInTransaction($in_transaction);
        }
    }

    public static function getInTransaction()
    {
        return static::$in_transaction;
    }

    public static function setInTransaction(bool $in_transaction)
    {
        static::$in_transaction = $in_transaction;
    }

    public static function resetInTransaction()
    {
        static::setInTransaction(false);
    }
}
