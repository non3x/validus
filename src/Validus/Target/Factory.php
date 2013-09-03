<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Target;

class Factory {

    /**
     * Check target's type and wrap it with appropriate container
     * 
     * @param object|array $target
     * @return \Validus\Target\StdObj|\Validus\Target\HashMap
     */
    static public function uniform($target) {
        if (is_object($target)) {
            return new StdObj($target);
        }
        if (is_array($target)) {
            return new HashMap($target);
        }
    }

}