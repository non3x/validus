<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

class Maxlength extends Base {

    public function applyTo($targetValue) {
        return (strlen($targetValue) <= $this->condition);
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("maximum length is {$this->condition}");
    }

}