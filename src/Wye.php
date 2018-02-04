<?php

namespace Stratedge\Wye;

use Exception;
use Stratedge\Wye\Collections\BacktraceCollection;
use Stratedge\Wye\Collections\BacktraceCollectionInterface;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Collections\BindingCollectionInterface;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Collections\StatementCollection;
use Stratedge\Wye\Collections\StatementCollectionInterface;
use Stratedge\Wye\PDO\PDO;
use Stratedge\Wye\PDO\PDOException;
use Stratedge\Wye\PDO\PDOStatement;

class Wye
{
    /**
     * @var StatementCollectionInterface|null
     */
    protected static $statements;

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
     * @var array
     */
    protected static $transactions = [];

    /**
     * @var bool
     */
    protected static $backtrace_all = false;

    /**
     * @var bool
     */
    protected static $backtrace_single = false;

    /**
     * @var int
     */
    protected static $backtrace_default_limit = 0;

    /**
     * @var int|null
     */
    protected static $backtrace_limit = null;


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
        static::resetInTransaction();
        static::resetTransactions();
        static::resetBacktraceForTest();
        static::resetBacktraceLimit();
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


    public static function makeTransaction($index = null)
    {
        $transaction = new Transaction($index);
        return $transaction;
    }

    /**
     * Creates a new instance of Stratedge\Wye\Binding.
     *
     * @param  int|string       $parameter
     * @param  mixed            $value
     * @param  int              $data_type
     * @return BindingInterface
     */
    public static function makeBinding(
        $parameter,
        $value,
        $data_type = PDO::PARAM_STR
    ) {
        $binding = new Binding(new static, $parameter, $value, $data_type);
        return $binding;
    }

    /**
     * Creates a new instance of BacktraceCollectionInterface.
     *
     * @param  array  $items
     * @return BacktraceCollectionInterface
     */
    public static function makeBacktraceCollection(array $items = [])
    {
        return new BacktraceCollection(new static, $items);
    }

    /**
     * Creates a new instance of BindingCollectionInterface.
     *
     * @param  array $items
     * @return BindingCollectionInterface
     */
    public static function makeBindingCollection(array $items = [])
    {
        $collection = new BindingCollection(new static, $items);
        return $collection;
    }

    /**
     * Creates a new instance of CollectionInterface.
     *
     * @param  array $items
     * @return CollectionInterface
     */
    public static function makeCollection(array $items = [])
    {
        return new Collection(new static, $items);
    }

    /**
     * Creates a new instance of StatementCollectionInterface.
     *
     * @param  array  $items
     * @return StatementCollectionInterface
     */
    public static function makeStatementCollection(array $items = [])
    {
        return new StatementCollection(new static, $items);
    }


    /**
     * Records a simulation of a query execution.
     *
     * @todo Raise an error if there are parameters already bound and params are
     *     provided.
     *
     * @param  PDOStatement $statement
     * @param  array        $params
     * @return void
     */
    public static function executeStatement(
        PDOStatement $statement,
        array $params = null
    ) {
        //Add the statement to the list of those run
        static::addStatement($statement);

        //Add bindings to the statement
        if (is_array($params)) {
            $statement->getBindings()
                ->hydrateFromArray($params);
        }

        $result = static::getOrCreateResultAt(static::numQueries());

        //Add the result to the statement
        $statement->setResult($result);

        //If a transaction is open, add the statement to it
        if (static::inTransaction()) {
            static::currentTransaction()->addStatement($statement);
        }

        //Increment number of queries run
        static::incrementNumQueries();

        if (static::shouldLogBacktrace()) {
            $statement->setBacktrace(
                static::makeBacktraceCollection(
                    debug_backtrace(
                        DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS,
                        static::resolveBacktraceLimit()
                    )
                )
            );
        }
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


    /**
     * Places Wye into transaction mode and increments number of transactions.
     * If a transaction is already open, throws a PDOException
     *
     * @todo Flesh out the details for the PDOException properly
     *
     * @throws PDOException
     *
     * @return void
     */
    public static function beginTransaction()
    {
        if (static::inTransaction()) {
            throw new PDOException();
        }

        static::inTransaction(true);

        $transaction = static::makeTransaction(static::countTransactions());

        static::addTransaction($transaction);
    }


    /**
     * Marks the current transaction as committed and removes Wye from
     * transaction mode. If no transaction exists, throws a PDOException.
     *
     * @todo Flesh out the details for the PDOException properly.
     *
     * @throws PDOException
     *
     * @return void
     */
    public static function commitTransaction()
    {
        if (static::getInTransaction() !== true) {
            throw new PDOException();
        }

        static::setInTransaction(false);

        static::currentTransaction()->setCommitted(true);
    }

    /**
     * Marks the current transaction as rolled back and removes Wye from
     * transaction mode. If no transaction exists, throws a PDOException.
     *
     * @todo Flesh out the details for the PDOException properly.
     *
     * @throws PDOException
     *
     * @return void
     */
    public static function rollBackTransaction()
    {
        if (static::getInTransaction() !== true) {
            throw new PDOException();
        }

        static::setInTransaction(false);

        static::currentTransaction()->setRolledBack(true);
    }


    //**************************************************************************
    // BACKTRACE
    //**************************************************************************

    /**
     * Retrieve the value of the backtrace-all property.
     *
     * @return bool
     */
    public static function getBacktraceAll()
    {
        return static::$backtrace_all;
    }

    /**
     * Retrieve the value of the backtrace-single property.
     *
     * @return bool
     */
    public static function getBacktraceSingle()
    {
        return static::$backtrace_single;
    }

    /**
     * Retrieve the value of the backtrace-default-limit property.
     *
     * @return int
     */
    public static function getBacktraceDefaultLimit()
    {
        return static::$backtrace_default_limit;
    }

    /**
     * Retrieve the value of the backtrace-limit property.
     *
     * @return int|null
     */
    public static function getBacktraceLimit()
    {
        return static::$backtrace_limit;
    }

    /**
     * Turn on backtrace logging for all the tests that run, ignoring resets.
     *
     * @return void
     */
    public static function logBacktraceForAllTests()
    {
        static::$backtrace_all = true;
    }

    /**
     * Turn on backtrace logging for all the current test only.
     *
     * @return void
     */
    public static function logBacktraceForTest()
    {
        static::$backtrace_single = true;
    }

    /**
     * Reset the value of the backtrace-default-limit property to 0.
     *
     * @return void
     */
    public static function resetBacktraceDefaultLimit()
    {
        static::$backtrace_default_limit = 0;
    }

    /**
     * Turn off backtrace logging for all tests.
     *
     * @return void
     */
    public static function resetBacktraceForAllTests()
    {
        static::$backtrace_all = false;
    }

    /**
     * Turn off backtrace logging for a single test.
     *
     * @return void
     */
    public static function resetBacktraceForTest()
    {
        static::$backtrace_single = false;
    }

    /**
     * Reset the value of the backtrace-limit property to null.
     *
     * @return void
     */
    public static function resetBacktraceLimit()
    {
        static::$backtrace_limit = null;
    }

    /**
     * Determine the backtrace limit that should be applied.
     *
     * @return int
     */
    public static function resolveBacktraceLimit()
    {
        return is_null(static::$backtrace_limit) ?
            static::$backtrace_default_limit :
            static::$backtrace_limit;
    }

    /**
     * Set the value of the backtrace-default-limit property.
     *
     * @param int $limit
     */
    public static function setBacktraceDefaultLimit($limit)
    {
        static::$backtrace_default_limit = $limit;
    }

    /**
     * Set the value of the backtrace-limit property.
     *
     * @param int $limit
     */
    public static function setBacktraceLimit($limit)
    {
        static::$backtrace_limit = $limit;
    }

    /**
     * Determine if backtrace logging is on or off at the time of call.
     *
     * @return bool
     */
    public static function shouldLogBacktrace()
    {
        return static::$backtrace_all || static::$backtrace_single;
    }



    //**************************************************************************
    // STATEMENTS
    //**************************************************************************

    /**
     * @deprecated
     */
    public static function statements($statements = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        if (is_null($statements)) {
            return static::getStatements();
        } else {
            return static::setStatements($statements);
        }
    }

    /**
     * Retrieve the value of the statements property.
     *
     * @return StatementCollectionInterface
     */
    public static function getStatements()
    {
        if (is_null(static::$statements)) {
            static::resetStatements();
        }

        return static::$statements;
    }

    /**
     * Set the value of the statements property.
     *
     * @param  StatementCollectionInterface $statements
     * @return void
     */
    public static function setStatements(StatementCollectionInterface $statements)
    {
        static::$statements = $statements;
    }

    /**
     * Reset the statements property to an empty collection.
     *
     * @return void
     */
    public static function resetStatements()
    {
        static::$statements = static::makeStatementCollection();
    }

    /**
     * Push a new statement onto the collection of statements.
     *
     * @param  PDOStatement $statement
     * @return void
     */
    public static function addStatement(PDOStatement $statement)
    {
        //Add statement
        static::getStatements()->push($statement);
    }

    /**
     * Retrieve the latest statement pushed into the collection.
     *
     * @return PDOStatement|null
     */
    public static function getLastStatement()
    {
        return static::getStatements()->last();
    }

    /**
     * Retrieve a statement at a specific index.
     *
     * @param  int $index
     * @return PDOStatement|null
     */
    public static function getStatementAtIndex($index = 0)
    {
        return static::getStatements()->get($index);
    }



    //**************************************************************************
    // RESULTS
    //**************************************************************************

    public static function getResults()
    {
        return static::$results;
    }

    public static function getResultAt($index = 0)
    {
        $results = static::getResults();

        return !empty($results[$index]) ? $results[$index] : null;
    }

    /**
     * Retrieve a result at a specific index. If no result is found, a new,
     * blank result will be generated, stored at the index, and returned.
     *
     * @param  integer $index
     * @return Result
     */
    public static function getOrCreateResultAt($index = 0)
    {
        $results = static::getResultAt($index);

        if (is_null($results)) {
            $results = static::makeResult()->attachAtIndex($index);
        }

        return $results;
    }

    public static function setResults($results)
    {
        static::$results = $results;
    }

    public static function resetResults()
    {
        static::setResults([]);
    }

    public static function addResult(Result $result)
    {
        // Add result
        $results = static::getResults();
        $results[] = $result;

        // Store results
        static::setResults($results);
    }

    /**
     * Attach a result at a specific index. If a result already exists the
     * current one will be replaced with the new one.
     *
     * @param Result  $result
     * @param integer $index
     */
    public static function addResultAtIndex(Result $result, $index)
    {
        // Add result
        $results = static::getResults();
        $results[$index] = $result;

        // Store results
        static::setResults($results);
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

    /**
     * @deprecated
     */
    public static function quotes($quotes = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

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

    public static function inTransaction($in_transaction = null)
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

    public static function setInTransaction($in_transaction)
    {
        static::$in_transaction = (bool) $in_transaction;
    }

    public static function resetInTransaction()
    {
        static::setInTransaction(false);
    }



    //**************************************************************************
    // TRANSACTIONS
    //**************************************************************************

    /**
     * @deprecated
     */
    public static function transactions(array $transactions = null)
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated', E_USER_DEPRECATED);

        if (is_null($transactions)) {
            return static::getTransactions();
        } else {
            return static::setTransactions($transactions);
        }
    }

    public static function getTransactions()
    {
        return static::$transactions;
    }

    public static function setTransactions(array $transactions)
    {
        static::$transactions = $transactions;
    }

    public static function resetTransactions()
    {
        static::setTransactions([]);
    }

    public static function addTransaction(Transaction $transaction)
    {
        static::$transactions[] = $transaction;
    }

    public static function countTransactions()
    {
        return count(static::$transactions);
    }

    public static function currentTransaction()
    {
        if (empty(static::getTransactions())) {
            throw new Exception("There are no transactions available.");
        }

        $transactions = static::getTransactions();

        return end($transactions);
    }
}
