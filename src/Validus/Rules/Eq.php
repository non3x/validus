<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

class Eq extends Base {

    public function applyTo($targetValue) {
        return ($this->condition == $targetValue);
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("{$this->propertyName} must be equal to {$this->condition}");
    }

}