<?php

namespace Stratedge\Wye\Collections;

interface StatementCollectionInterface extends CollectionInterface
{
    /**
     * Create a new collection of the query statements that were executed by the
     * PDOStatements in the collection.
     *
     * @return CollectionInterface
     */
    public function getStatements();
}
