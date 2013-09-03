<?php

/**
 * @author    Zakharenko Mikhail <zakharenko.mikhail@gmail.com> 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Target;

abstract class Container {

    /** @var type Reference to real target object, e.g $user model */
    protected $target;

    public function __construct($target) {
        $this->target = $target;
    }

    /**
     * Access target's properties by name
     * 
     * @param string $name property name
     * @return mixed
     */
    abstract public function getValueByName($name);

    /**
     * @return array Of properties names or array keys
     */
    abstract public function getPropertiesNames();
}