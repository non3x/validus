<?php

/**
 * @author    Zakharenko Mikhail 
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus\Target;

class Property {

    /** @var mixed Object property name or assoc. array key */
    protected $name = null;

    /** @var boolean In order to proceed we need all Rules satisfied */
    protected $allRulesPassed = false;

    /** @var \Validus\Rules\Base Rules attached to this property */
    protected $rules = array();

    /** @var array Errors from rules invokation */
    protected $errors = array();

    public function __construct($name) {
        $this->setName($name);
    }

    public function attachRule($rule) {
        return $this->rules[] = $rule;
    }

    public function getAttachedRules() {
        return $this->rules;
    }

    /**
     * Ierate over property's rules and check if conditions are met.
     * 
     * @param mixed $targetValue
     * @return boolean
     */
    public function applyRules($targetValue) {
        $this->allRulesPassed = true;
        foreach ($this->rules as $rule) {
            if (!$rule->satisfied($targetValue)) {
                $this->addError($rule->getErrorMessage());
                $this->allRulesPassed = false;
            }
        }
        return $this->allRulesPassed;
    }

    public function addError($error) {
        $this->errors[] = $error;
    }

    public function clearErrors()
    {
        $this->errors = array();
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getID() {
        return spl_object_hash($this);
    }

    public function rulesPassed() {
        return $this->allRulesPassed;
    }

}