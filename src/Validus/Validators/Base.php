<?php

/**
 * Base validator for objects and array containers.
 * 1) Register property name and attach rules
 * 2) Apply rules to given target (object or array)
 * 3) Return all or specified property errors (if any)
 * 
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Validators;

use \Validus\Exceptions as Exceptions;
use \Validus\Target as Target;

abstract class Base {

    /** @var Validus\Target\Property array This is where properties live. */
    protected $properties = array();

    /** @var array We need name -> id association for errors handling */
    protected $propertiesNames = array();

    /**
     * For given property check if Target\Property was instantiated, 
     * if not - do so, then add it to the internal properties array 
     * and attach specified rule to it. This is done in order to avoid 
     * multiple Property objects for the same property name.
     * 
     * @param string $pName
     * @param \Validus\Rules\Base $rule
     * @throws \Validus\Exceptions\InvalidArgument
     * @return true
     */
    protected function addRule($pName, $rule) {
        if (!$this->isValidPropertyName($pName)) {
            throw new Exceptions\InvalidArgument("Property name can't be empty");
        }
        if (!empty($this->propertiesNames[$pName])) {
            $pID = $this->propertiesNames[$pName];
            $property = $this->properties[$pID];
        } else {
            $property = new Target\Property($pName);
            $pID = $property->getID();
            $this->properties[$pID] = $property;
            $this->propertiesNames[$pName] = $pID;
        }
        return $property->attachRule($rule);
    }

    /**
     * Instantiate target container with Target\Factory, so we can access
     * it's values in an uniform way, then for each registered
     * property apply assigned rules. Return false if all of the rules are 
     * passing their checks, true otherwise (because method is «fails»).
     *
     * @param object|array $target
     * @return boolean
     */
    public function fails($target) {
        $isValidTarget = true;
        $target = Target\Factory::uniform($target);
        foreach ($this->properties as $property) {
            $property->clearErrors();
            $targetValue = $target->getValueByName($property->getName());
            if (!$property->applyRules($targetValue)) {
                $isValidTarget = false;
            }
        }
        return !$isValidTarget;
    }

    /**
     * For each property fetch errors from failing rules
     * and return associative array with them.
     * 
     * @return array ["propertyName" => ['error1','error2']]
     */
    public function errors() {
        $errors = array();
        foreach ($this->properties as $property) {
            if (!$property->rulesPassed()) {
                $errors[$property->getName()] = $property->getErrors();
            }
        }
        return $errors;
    }

    /**
     * Fetch errors for specified property, in case you need to.
     * 
     * @param string $pName
     * @throws \Validus\Exceptions\InvalidArgument
     * @return array ['error1','error2']
     */
    public function errorsFor($pName) {
        if (!$this->isValidPropertyName($pName)) {
            throw new Exceptions\InvalidArgument("Property name can't be empty");
        }
        if (!empty($this->propertiesNames[$pName])) {
            $pID = $this->propertiesNames[$pName];
            return $this->properties[$pID]->getErrors();
        }
        return array();
    }

    /**
     * Property name must be string and not empty
     * 
     * @param type $pName property name
     * @return boolean
     */
    protected function isValidPropertyName($pName) {
        if (empty($pName) or !is_string($pName)) {
            return false;
        }
        return true;
    }

}