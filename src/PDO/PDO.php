<?php

namespace Stratedge\Wye\PDO;

use InvalidArgumentException;
use PDO as BasePDO;
use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

/**
 * @todo
 *   - Implement the `beginTransaction` method
 *   - Implement the `commit` method
 *   - Implement the `errorCode` method
 *   - Implement the `errorInfo` method
 *   - Implement the `exec` method
 *   - Implement the `getAttribute` method
 *   - Implement the `getAvailableDrivers` method
 *   - Implement the `inTransaction` method
 *   - Implement the `lastInsertId` method
 *   - Implement the `query` method
 *   - Implement the `quote` method
 *   - Implement the `rollBack` method
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
     * Mimic for PDO::prepare(). Generates and returns a mock PDOStatement
     *
     * @param  string $statement
     * @param  array  $options
     * @return PDOStatement
     */
    public function prepare($statement, $options = null)
    {
        return $this->wye()->makeStatement($statement, $options);
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

        return $this->wye()->quote($string);
    }
}
