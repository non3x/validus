<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Target;

class HashMap extends Container {

    public function getValueByName($name) {
        if (!empty($this->target[$name])) {
            return $this->target[$name];
        }
        return false;
    }

    public function getPropertiesNames() {
        return array_keys($this->target);
    }

}