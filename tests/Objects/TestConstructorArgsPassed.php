<?php

namespace Tests\Objects;

/**
 * Test class used to test if constructor arguments are passed to new objects
 * created by Row::formatClass()
 */
class TestConstructorArgsPassed
{
    public $first;
    public $second;

    public function __construct($first, $second)
    {
        $this->first = $first;
        $this->second = $second;
    }
}
