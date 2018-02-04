<?php

namespace Stratedge\Wye\Collections;

interface BacktraceCollectionInterface extends CollectionInterface
{
    /**
     * Return a new collection of strings formatted generally into the
     * print_debug_backtrace() format.
     *
     * @return CollectionInterface
     */
    public function getTrace();
}
