<?php

/**
 * @author  Zakharenko Mikhail <zakharenko.mikhail@gmail.com>
 * @copyright    Copyright 2013, Zakharenko Mikhail
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 */

namespace Validus;

/**
 * @method \Validus\Validus notempty(mixed $condition, string $message)
 * @method \Validus\Validus email(mixed $condition, string $message)
 * @method \Validus\Validus closure(mixed $condition, string $message)
 * @method \Validus\Validus eq(mixed $condition, string $message)
 * @method \Validus\Validus lt(mixed $condition, string $message)
 * @method \Validus\Validus gt(mixed $condition, string $message)
 * @method \Validus\Validus maxlength(mixed $condition, string $message)
 * @method \Validus\Validus minlength(mixed $condition, string $message)
 * @method \Validus\Validus length(mixed $condition, string $message)
 * @method \Validus\Validus regexp(mixed $condition, string $message)
 */
class Validus extends Validators\Base {

    /**
     * Property names to which we will apply rules,
     * cleared with «on» method call.
     * @var array
     */
    protected $workOnProperties = array();

    /**
     * Add property name to internal properties stack
     * in order to apply defined rules later to it.
     * This is done to support the «entire» method
     * functionality, i.e when we want to apply same
     * rule to multiple properties we'll iterate over
     * [prop1,prop2...] array which is workOnProperties.
     *
     * @param string|array $properties
     * @return \Validus\Validus
     * @throws \Validus\Exceptions\InvalidArgument
     */
    public function on($properties) {
        $this->workOnProperties = array();
        foreach ((array) $properties as $propertyName) {
            if (!$this->isValidPropertyName($propertyName)) {
                throw new Exceptions\InvalidArgument("Property name can't be empty");
            }
            $this->workOnProperties[] = $propertyName;
        }
        return $this;
    }

    /**
     * Enable user to «copy» rules from one property
     * to another in a snap. To avoid error message
     * collision new rules are instantiated for specified
     * property with the source rule condition but default
     * error message.
     *
     * @param type $propertyName
     * @return \Validus\Validus
     * @throws Exceptions\InvalidArgument
     */
    public function sameAs($propertyName) {
        if (!$this->isValidPropertyName($propertyName)) {
            throw new Exceptions\InvalidArgument("Property name can't be empty");
        }
        if (!empty($this->propertiesNames[$propertyName])) {
            $pID = $this->propertiesNames[$propertyName];
            $property = $this->properties[$pID];
            foreach ($property->getAttachedRules() as $rule) {
                foreach ($this->workOnProperties as $pName) {
                    $this->addRule(
                            $pName, $rule->__new($rule->getCondition(), $pName)
                    );
                }
            }
        }
        return $this;
    }

    /**
     * Given a target container fetch it's properties
     * and put them into our internal array. Rules
     * will be attached with following calls, e.g
     * $v->entire($user)->notempty(); will provide us
     * with notEmpty validation on all user's properties.
     *
     * @param type $target
     * @return \Validus\Validus
     */
    public function entire($target) {
        $target = Target\Factory::uniform($target);
        $this->workOnProperties = $target->getPropertiesNames();
        return $this;
    }

    /**
     * Since we don't want to specify all rules instantiation
     * routines we'll intercept ->ruleName() calls, which 
     * will be directly mapped to class names, instantiate
     * rule object and add it to specified properties.
     * 
     * @param type $name
     * @param type $arguments
     * @return \Validus\Validus
     * @throws \Validus\Exceptions\RuleDoesntExist
     */
    public function __call($name, $arguments) {
        $condition = isset($arguments[0]) ? $arguments[0] : null;
        $message = isset($arguments[1]) ? $arguments[1] : null;
        $ruleClass = 'Validus\Rules\\' . ucfirst(strtolower($name));
        if (!class_exists($ruleClass)) {
            throw new \Validus\Exceptions\RuleDoesntExist($ruleClass);
        }
        foreach ($this->workOnProperties as $propertyName) {
            $this->addRule($propertyName, new $ruleClass($condition, $propertyName, $message));
        }
        return $this;
    }

}