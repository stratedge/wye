<?php

namespace Stratedge\Wye\PDO;

use InvalidArgumentException;
use PDO as BasePDO;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

/**
 * @todo
 *   - Finish the `commit` method
 *   - Implement the `errorCode` method
 *   - Implement the `errorInfo` method
 *   - Implement the `exec` method
 *   - Implement the `getAttribute` method
 *   - Implement the `getAvailableDrivers` method
 *   - Implement the `inTransaction` method
 *   - Finish the `lastInsertId` method
 *   - Implement the `query` method
 *   - Finish the `rollBack` method
 *   - Implement the `setAttribute` method
 */
class PDO extends BasePDO
{
    use UsesWye;


    /**
     * @param Wye $wye
     */
    public function __construct(Wye $wye)
    {
        $this->setWye($wye);
    }



    //**************************************************************************
    // PDO METHODS
    //**************************************************************************

    /**
     * Mimic for PDO::beginTransaction(). Records a new transaction on the Wye
     *
     * @return true
     */
    public function beginTransaction()
    {
        Wye::beginTransaction();

        return true;
    }

    /**
     * Mimic for PDO::commit(). Commits the currently active transaction, or
     * throws a PDOException if no transaction exists.
     *
     * @todo Allow false to be returned.
     *
     * @return true
     */
    public function commit()
    {
        $this->getWye()->commitTransaction();

        return true;
    }

    /**
     * Mimic for PDO::exec(). Executes the provided query.
     *
     * @param  string $query
     * @return int
     */
    public function exec($query)
    {
        $stmt = $this->getWye()->makeStatement($query, []);

        $stmt->execute();

        return $stmt->rowCount() !== null ? $stmt->rowCount() : 0;
    }

    /**
     * Mimic for PDO::lastInsertId(). Returns the last insert ID value for the
     * last used statement result.
     *
     * @todo Handle the scenario where there is no result set to reference
     * @todo Implement the name parameter
     * @todo Handle returning the correct value when transactions are involved
     *
     * @param  string|null $name
     * @return string|null
     */
    public function lastInsertId($name = null)
    {
        return $this->getWye()
            ->getLastStatement()
            ->getResult()
            ->getLastInsertId();
    }


    /**
     * Mimic for PDO::prepare(). Generates and returns a mock PDOStatement
     *
     * @param  string $statement
     * @param  array  $options
     * @return PDOStatement
     */
    public function prepare($statement, $options = null)
    {
        return $this->getWye()->makeStatement($statement, $options);
    }


    /**
     * Mimic for PDO::quote(). Stores the string and given option(s) on the Wye
     * and returns the given string wrapped in quote tags with a reference to
     * which number call to quote the current call is (<quote:0></quote:0>)
     *
     * @param  stromg  $string
     * @param  integer $paramtype
     * @return string
     */
    public function quote($string, $paramtype = null)
    {
        if (!is_string($string)) {
            throw new InvalidArgumentException(
                sprintf(
                    "PDO:quote() expects parameter 1 to be a string, %s given.",
                    gettype($string)
                )
            );
        }

        return $this->getWye()->quote($string);
    }

    /**
     * Mimic for PDO::rollBack(). Rolls back the currently active transaction,
     * or throws a PDOException if no transaction exists.
     *
     * @todo Allow false to be returned.
     *
     * @return true
     */
    public function rollBack()
    {
        $this->getWye()->rollBackTransaction();

        return true;
    }
}
