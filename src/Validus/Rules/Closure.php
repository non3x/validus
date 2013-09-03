<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Rules;

use \Validus\Exceptions as Exceptions;

class Closure extends Base {

    public function applyTo($targetValue) {
        return (boolean) $this->invokeClosure($targetValue);
    }

    protected function invokeClosure($targetValue) {
        if (is_callable($this->condition)) {
            $reflection = new \ReflectionFunction($this->condition);
            if (!$reflection->isClosure()) {
                throw new Exceptions\NotCallable("Specified condition is not closure, can't proceed");
            }
            return $reflection->invokeArgs(array($targetValue));
        }
        return false;
    }

    public function setDefaultErrorMessage() {
        $this->setErrorMessage("Condition for {$this->propertyName} is not met");
    }

}