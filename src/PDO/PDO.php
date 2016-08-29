<?php

namespace Stratedge\Wye\PDO;

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
}
