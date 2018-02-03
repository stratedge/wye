<?php

namespace Tests;

// use PHPUnit_Framework_TestCase as BaseTestCase;
use Stratedge\Wye\Wye;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        Wye::reset();
        Wye::resetBacktraceForAllTests();
    }
}
