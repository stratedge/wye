<?php

namespace Stratedge\Wye\Collections;

use Stratedge\Wye\PDO\PDOStatement;
use Stratedge\Wye\Wye;

class StatementCollection extends Collection implements StatementCollectionInterface
{
    /**
     * Create a new instance of PDOStatementCollection.
     *
     * @param Wye   $wye
     * @param array $items
     */
    public function __construct(Wye $wye, $items = [])
    {
        parent::__construct($wye, $items, PDOStatement::class);
    }

    /**
     * Create a new collection of the query statements that were executed by the
     * PDOStatements in the collection.
     *
     * @return CollectionInterface
     */
    public function getStatements()
    {
        return $this->map(function ($item) {
            return $item->getStatement();
        });
    }
}
