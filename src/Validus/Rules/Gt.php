<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

class Gt extends Base {

    public function applyTo($targetValue) {
        return ($targetValue > $this->condition);
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("{$this->propertyName} must be greater than {$this->condition}");
    }

}