<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

abstract class Base {

    /** @var string Property name for default error messages */
    protected $propertyName;

    /** @var mixed Condition that should be satisfied, e.g int, regexp or closure */
    protected $condition;

    /** @var bool By default every rule will return false on failure, so check for true */
    protected $expectedResult = true;

    /** @var string The message you will get if condition is not satisfied */
    protected $errorMessage;

    public function __construct($condition, $propertyName, $errorMessage = null) {
        $this->setCondition($condition);
        $this->setPropertyName($propertyName);
        if (!empty($errorMessage)) {
            $this->setErrorMessage($errorMessage);
        } else {
            $this->setDefaultErrorMessage();
        }
    }

    // We need this method for «sameAs» functionality
    public function __new($condition, $errorMessage = null) {
        return new static($condition, $errorMessage);
    }

    abstract protected function applyTo($targetValue);

    abstract public function setDefaultErrorMessage();

    public function satisfied($targetValue) {
        return ($this->applyTo($targetValue) == $this->expectedResult);
    }

    public function setCondition($input) {
        $this->condition = $input;
    }

    public function getCondition() {
        return $this->condition;
    }

    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

    public function getPropertyName() {
        return $this->propertyName;
    }

    public function setPropertyName($propertyName) {
        $this->propertyName = $propertyName;
    }

}