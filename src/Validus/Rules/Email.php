<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

use \Validus\Exceptions as Exceptions;

class Email extends Base {

    public function applyTo($targetValue) {
        return (boolean) $this->isValid($targetValue);
    }

    private function isValid($email) {
        if (function_exists('filter_var')) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("{$this->propertyName} is not in valid format");
    }

}