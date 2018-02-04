<?php

namespace Tests\Unit\Collections\BacktraceCollection;

use Stratedge\Wye\Collections\BacktraceCollection;
use Stratedge\Wye\Collections\CollectionInterface;
use Stratedge\Wye\Wye;

class GetTraceTest extends \Tests\TestCase
{
    public function testReturnsNewCollection()
    {
        $collection = Wye::makeBacktraceCollection();

        $new = $collection->getTrace();

        $this->assertNotSame($new, $collection);
        $this->assertInstanceOf(CollectionInterface::class, $new);
    }

    public function testFormatsItemsCorrectly()
    {
        $all = [
            'class' => 'a',
            'type' => 'b',
            'function' => 'c',
            'file' => 'd',
            'line' => '1'
        ];

        $keys = [
            'class',
            'type',
            'function',
            'file',
            'line',
        ];

        $data[] = $all;

        foreach ($keys as $key) {
            $data[] = array_merge($all, [$key => null]);
        }

        $collection = Wye::makeBacktraceCollection($data);

        $expected = [
            '#0 abc() called at [d:1]',
            '#1 bc() called at [d:1]',
            '#2 ac() called at [d:1]',
            '#3 ab() called at [d:1]',
            '#4 abc() called at [:1]',
            '#5 abc() called at [d:0]',
        ];

        $this->assertSame($expected, $collection->getTrace()->all());
    }

    public function testFormatsArgsCorrectly()
    {
        $values = [
            [true],
            [false],
            [null],
            [[]],
            [[1, 2]],
            [['test' => 1]],
            [Wye::makeBacktraceCollection()],
            ['123'],
            ['1.2'],
            ['-8'],
            ['cool'],
            [123],
            [1.2],
            [-8],
            ['test', 'multiple', 'values'],
        ];

        foreach ($values as $value) {
            $data[] = ['args' => $value];
        }

        $expected = [
            '#0 (true) called at [:0]',
            '#1 (false) called at [:0]',
            '#2 (null) called at [:0]',
            '#3 (array(0)) called at [:0]',
            '#4 (sequential-array(2)) called at [:0]',
            '#5 (associative-array(1)) called at [:0]',
            '#6 (' . BacktraceCollection::class . ') called at [:0]',
            '#7 ("123") called at [:0]',
            '#8 ("1.2") called at [:0]',
            '#9 ("-8") called at [:0]',
            '#10 ("cool") called at [:0]',
            '#11 (123) called at [:0]',
            '#12 (1.2) called at [:0]',
            '#13 (-8) called at [:0]',
            '#14 ("test", "multiple", "values") called at [:0]',
        ];

        $collection = Wye::makeBacktraceCollection($data);

        $this->assertSame($expected, $collection->getTrace()->all());
    }
}
