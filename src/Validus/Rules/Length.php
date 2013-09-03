<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

class Length extends Base {

    public function applyTo($targetValue) {
        $max = new MaxLength($this->condition);
        $min = new MinLength($this->condition);
        return ($max->applyTo($targetValue) & $min->applyTo($targetValue));
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("{$this->propertyName} length must be equal to {$this->condition}");
    }

}