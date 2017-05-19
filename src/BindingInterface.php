<?php

namespace Stratedge\Wye;

interface BindingInterface
{
    /**
     * Retrieve the value of the parameter property.
     *
     * @return string
     */
    public function getParameter();

    /**
     * Set the value of the parameter property.
     *
     * @param  string $parameter
     * @return self
     */
    public function setParameter($parameter);

    /**
     * Retrieve the value of the value property.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set the value of the value property.
     *
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Retrieve the value of the data_type property.
     *
     * @return int
     */
    public function getDataType();

    /**
     * Set the value of the data_type property.
     *
     * @param int $data_type
     */
    public function setDataType($data_type);

    /**
     * Determine if the data_type property represents a boolean value.
     *
     * @return boolean
     */
    public function isBoolean();

    /**
     * Determine if the data_type property represents a boolean value.
     *
     * @see self::isBoolean()
     *
     * @return boolean
     */
    public function isBool();

    /**
     * Determine if the data_type property represents a null value.
     *
     * @return boolean
     */
    public function isNull();

    /**
     * Determine if the data_type property represents an integer value.
     *
     * @return boolean
     */
    public function isInteger();

    /**
     * Determine if the data_type property represents an integer value.
     *
     * @see self::isInteger()
     *
     * @return boolean
     */
    public function isInt();

    /**
     * Determine if the data_type property represents a string value.
     *
     * @return boolean
     */
    public function isString();

    /**
     * Determine if the data_type property represents a string value.
     *
     * @see self::isString()
     *
     * @return boolean
     */
    public function isStr();

    /**
     * Determine if the data_type property represents a large object value.
     *
     * @return boolean
     */
    public function isLargeObject();

    /**
     * Determine if the data_type property represents a large object value.
     *
     * @see Binding::isLOB()
     *
     * @return boolean
     */
    public function isLOB();

    /**
     * Determine if the data_type property represents a statement value.
     *
     * @return boolean
     */
    public function isStatement();

    /**
     * Determine if the data_type property represents a statement value.
     *
     * @see Binding::isStatement()
     *
     * @return boolean
     */
    public function isStmt();

    /**
     * Determine if the data_type property represents an input-output value.
     *
     * @return boolean
     */
    public function isInputOutput();
}
