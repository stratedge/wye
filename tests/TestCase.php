<?php

namespace Tests;

use PHPUnit_Framework_TestCase as BaseTestCase;
use Stratedge\Wye\Wye;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        Wye::reset();
    }
}
