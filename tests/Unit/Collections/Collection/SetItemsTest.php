<?php

namespace Tests\Unit\Collections\Collection;

use Exception;
use InvalidArgumentException;
use Stratedge\Wye\Collections\Collection;
use Stratedge\Wye\Wye;

class SetItemsTest extends \Tests\TestCase
{
    public function testItemsAreSet()
    {
        $collection = new Collection(new Wye);

        $this->assertSame([], $collection->all());

        $collection->setItems([1, 2, 3]);

        $this->assertSame([1, 2, 3], $collection->all());
    }

    public function testItemsAreOverwritten()
    {
        $collection = new Collection(new Wye, [1, 2]);

        $this->assertSame([1, 2], $collection->all());

        $collection->setItems([3, 4, 5]);

        $this->assertSame([3, 4, 5], $collection->all());
    }

    public function testReturnsSelf()
    {
        $collection = new Collection(new Wye, [1, 2]);

        $this->assertSame(
            $collection->setItems([3, 4, 5]),
            $collection
        );
    }

    public function testInvalidItemsWhenExpectingBooleanThrowsException()
    {
        $collection = new Collection(new Wye, [], 'boolean');

        foreach ([1, 1.2, 'test', [['test']], null] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testInvalidItemsWhenExpectingIntegerThrowsException()
    {
        $collection = new Collection(new Wye, [], 'integer');

        foreach ([true, false, 1.2, 'test', [['test']], null, Wye::makeResult()] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testInvalidItemsWhenExpectingDoubleThrowsException()
    {
        $collection = new Collection(new Wye, [], 'double');

        foreach ([true, false, 1, 'test', [['test']], null, Wye::makeResult()] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testInvalidItemsWhenExpectingStringThrowsException()
    {
        $collection = new Collection(new Wye, [], 'string');

        foreach ([true, false, 1, 1.2, [['test']], null, Wye::makeResult()] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testInvalidItemsWhenExpectingArrayThrowsException()
    {
        $collection = new Collection(new Wye, [], 'array');

        foreach ([true, false, 1, 1.2, 'test', null, Wye::makeResult()] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testInvalidItemsWhenExpectingClassThrowsException()
    {
        $collection = new Collection(new Wye, [], Collection::class);

        foreach ([true, false, 1, 1.2, 'test', [['test']], null, Wye::makeResult()] as $ipt) {
            try {
                $collection->setItems([$ipt]);
                $this->fail('Expected InvalidArgumentException not thrown for ' . is_object($ipt) ? get_class($ipt) : gettype($ipt));
            } catch (InvalidArgumentException $e) {
                //
            }
        }
    }

    public function testBooleanAccepted()
    {
        $collection = new Collection(new Wye, [], 'boolean');

        $input = [true, false];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testIntegerAccepted()
    {
        $collection = new Collection(new Wye, [], 'integer');

        $input = [1, 2, 3];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testDoubleAccepted()
    {
        $collection = new Collection(new Wye, [], 'double');

        $input = [1.3, 2.5, 3.1];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testStringAccepted()
    {
        $collection = new Collection(new Wye, [], 'string');

        $input = ['engine', 'ladder'];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testArrayAccepted()
    {
        $collection = new Collection(new Wye, [], 'array');

        $input = [['engine'], ['ladder']];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testObjectAccepted()
    {
        $collection = new Collection(new Wye, [], 'object');

        $input = [new \stdClass];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testNullAccepted()
    {
        $collection = new Collection(new Wye, [], 'NULL');

        $input = [null];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }

    public function testClassAccepted()
    {
        $collection = new Collection(new Wye, [], Wye::class);

        $input = [new Wye];

        $collection->setItems($input);

        $this->assertSame($input, $collection->all());
    }
}
