<?php

namespace Stratedge\Wye;

use InvalidArgumentException;
use PDO;
use Stratedge\Wye\Traits\UsesWye;
use Stratedge\Wye\Wye;

class Binding
{
    use UsesWye;

    /**
     * @var mixed
     */
    protected $parameter;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var int
     */
    protected $data_type;

    /**
     * Create a new instance of Binding.
     *
     * @param Wye    $wye
     * @param string $parameter
     * @param mixed  $value
     * @param int    $data_type
     */
    public function __construct(
        Wye $wye,
        $parameter,
        $value,
        $data_type = PDO::PARAM_STR
    ) {
        $this->setWye($wye);
        $this->setParameter($parameter);
        $this->setValue($value);
        $this->setDataType($data_type);
    }

    /**
     * Retrieve the value of the parameter property.
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * Set the value of the parameter property.
     *
     * @param  string $parameter
     * @return self
     */
    public function setParameter($parameter)
    {
        if (!is_string($parameter)) {
            throw new InvalidArgumentException(
                'Binding parameter value must be a string.'
            );
        }

        $this->parameter = $parameter;

        return $this;
    }

    /**
     * Retrieve the value of the value property.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the value property.
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Retrieve the value of the data_type property.
     *
     * @return int
     */
    public function getDataType()
    {
        return $this->data_type;
    }

    /**
     * Set the value of the data_type property.
     *
     * @param int $data_type
     */
    public function setDataType($data_type)
    {
        if (!is_int($data_type)) {
            throw new InvalidArgumentException(
                'Binding data type value must be an integer.'
            );
        }

        $this->data_type = $data_type;

        return $this;
    }

    /**
     * Determine if the data_type property represents a boolean value.
     *
     * @return boolean
     */
    public function isBoolean()
    {
        return $this->data_type === PDO::PARAM_BOOL ||
            $this->data_type === (PDO::PARAM_BOOL | PDO::PARAM_INPUT_OUTPUT);
    }

    /**
     * Determine if the data_type property represents a boolean value.
     *
     * @see self::isBoolean()
     *
     * @return boolean
     */
    public function isBool()
    {
        return $this->isBoolean();
    }

    /**
     * Determine if the data_type property represents a null value.
     *
     * @return boolean
     */
    public function isNull()
    {
        return $this->getDataType() === PDO::PARAM_NULL;
    }

    /**
     * Determine if the data_type property represents an integer value.
     *
     * @return boolean
     */
    public function isInteger()
    {
        return $this->data_type === PDO::PARAM_INT ||
            $this->data_type === (PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
    }

    /**
     * Determine if the data_type property represents an integer value.
     *
     * @see self::isInteger()
     *
     * @return boolean
     */
    public function isInt()
    {
        return $this->isInteger();
    }

    /**
     * Determine if the data_type property represents a string value.
     *
     * @return boolean
     */
    public function isString()
    {
        return $this->data_type === PDO::PARAM_STR ||
            $this->data_type === (PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
    }

    /**
     * Determine if the data_type property represents a string value.
     *
     * @see self::isString()
     *
     * @return boolean
     */
    public function isStr()
    {
        return $this->isString();
    }

    /**
     * Determine if the data_type property represents a large object value.
     *
     * @return boolean
     */
    public function isLargeObject()
    {
        return $this->data_type === PDO::PARAM_LOB ||
            $this->data_type === (PDO::PARAM_LOB | PDO::PARAM_INPUT_OUTPUT);
    }

    /**
     * Determine if the data_type property represents a large object value.
     *
     * @see Binding::isLOB()
     *
     * @return boolean
     */
    public function isLOB()
    {
        return $this->isLargeObject();
    }

    /**
     * Determine if the data_type property represents a statement value.
     *
     * @return boolean
     */
    public function isStatement()
    {
        return $this->data_type === PDO::PARAM_STMT ||
            $this->data_type === (PDO::PARAM_STMT | PDO::PARAM_INPUT_OUTPUT);
    }

    /**
     * Determine if the data_type property represents a statement value.
     *
     * @see Binding::isStatement()
     *
     * @return boolean
     */
    public function isStmt()
    {
        return $this->isStatement();
    }

    /**
     * Determine if the data_type property represents an input-output value.
     *
     * @return boolean
     */
    public function isInputOutput()
    {
        return ($this->getDataType() & PDO::PARAM_INPUT_OUTPUT) === PDO::PARAM_INPUT_OUTPUT;
    }
}
