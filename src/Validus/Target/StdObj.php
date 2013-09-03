<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Target;

class StdObj extends Container {

    public function getValueByName($name) {
        if (!empty($this->target->{$name})) {
            return $this->target->{$name};
        }
        return false;
    }

    public function getPropertiesNames() {
        return array_keys(get_object_vars($this->target));
    }

}