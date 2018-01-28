<?php

namespace Tests\Unit\PDO\PDOStatement;

use Stratedge\Wye\Wye;
use Stratedge\Wye\PDO\PDO;
use Tests\TestCase;

class SetFetchModeTest extends TestCase
{
    public function testDefaultsToDefaultFetchMode()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertAttributeSame(
            [PDO::ATTR_DEFAULT_FETCH_MODE],
            "fetch_mode",
            $statement
        );
    }


    public function testReturnsTrue()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertTrue($statement->setFetchMode(PDO::FETCH_BOTH));
    }


    public function testSetsFetchModeProperty()
    {
        $statement = Wye::makeStatement("", []);

        $statement->setFetchMode(PDO::FETCH_BOTH);

        $this->assertAttributeSame([PDO::FETCH_BOTH], "fetch_mode", $statement);
    }


    public function testAssertIsArray()
    {
        $statement = Wye::makeStatement("", []);

        $this->assertAttributeInternalType("array", "fetch_mode", $statement);

        $statement->setFetchMode(PDO::FETCH_OBJ);

        $this->assertAttributeInternalType("array", "fetch_mode", $statement);
    }


    public function testMaximumOfThreeArgumentsStored()
    {
        $statement = Wye::makeStatement("", []);

        $statement->setFetchMode(PDO::FETCH_NUM, "some_class", ["args" => true], "excluded");

        $this->assertAttributeCount(3, "fetch_mode", $statement);
    }


    public function testFetchModeSetAsFirstItem()
    {
        $statement = Wye::makeStatement("", []);

        $statement->setFetchMode(PDO::FETCH_CLASS, "some_class", ["args" => true]);

        $fetch_mode = $statement->fetchMode();

        $this->assertSame(PDO::FETCH_CLASS, $fetch_mode[0]);
    }


    public function testSecondArgumentSetAsSecondItem()
    {
        $statement = Wye::makeStatement("", []);

        $statement->setFetchMode(PDO::FETCH_CLASS, "some_class", ["args" => true]);

        $fetch_mode = $statement->fetchMode();

        $this->assertSame("some_class", $fetch_mode[1]);
    }


    public function testThirdArgumentSetAsThirdItem()
    {
        $statement = Wye::makeStatement("", []);

        $statement->setFetchMode(PDO::FETCH_CLASS, "some_class", ["args" => true]);

        $fetch_mode = $statement->fetchMode();

        $this->assertSame(["args" => true], $fetch_mode[2]);
    }
}
