<?php

namespace Tests\Collections\BindingCollection;

use PDO;
use Stratedge\Wye\Binding;
use Stratedge\Wye\Collections\BindingCollection;
use Stratedge\Wye\Wye;

class FilterByDataTypeTest extends \Tests\TestCase
{
    public function testReturnsNewSameType()
    {
        $collection = new BindingCollection(new Wye);

        $result = $collection->filterByDataType(PDO::PARAM_STR);

        $this->assertInstanceOf(get_class($collection), $result);
        $this->assertNotSame($collection, $result);
    }

    public function testFiltersBoolType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_STR);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_BOOL);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_BOOL);

        $this->assertSame([$second, $third], $result->values()->all());
    }

    public function testFiltersNullType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_STR);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_NULL);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_NULL);

        $this->assertSame([$second], $result->values()->all());
    }

    public function testFiltersIntType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_STR);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_INT);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_INT);

        $this->assertSame([$second, $third], $result->values()->all());
    }

    public function testFiltersStrType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_INT);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_STR);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_STR);

        $this->assertSame([$second, $third], $result->values()->all());
    }

    public function testFiltersLOBType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_INT);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_LOB);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_LOB | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_LOB);

        $this->assertSame([$second, $third], $result->values()->all());
    }

    public function testFiltersStmtType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_INT);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_STMT);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_STMT | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_STMT);

        $this->assertSame([$second, $third], $result->values()->all());
    }

    public function testFiltersInputOutputType()
    {
        $first = new Binding(new Wye, 'apparatus', 'Engine 1', PDO::PARAM_INT);
        $second = new Binding(new Wye, 'type', 'Pumper', PDO::PARAM_STR);
        $third = new Binding(new Wye, 'seats', 5, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);

        $bindings = [
            $first,
            $second,
            $third,
        ];

        $collection = new BindingCollection(new Wye, $bindings);

        $result = $collection->filterByDataType(PDO::PARAM_INPUT_OUTPUT);

        $this->assertSame([$third], $result->values()->all());
    }
}
