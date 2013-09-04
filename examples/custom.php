<?php

// This example shows two ways of defining your custom validation rules
//   - By calling addRule() on validator directly with custom rule instance
//   - By defining your rule class in \Validus\Rules namespace, so it will be picked
//      and instantiated automagically by autoloader.

namespace {

    error_reporting(E_STRICT | E_ALL);
    ini_alter('display_errors', 'on');

    require '../vendor/autoload.php';

// In case you want custom validation Rule, you should
// extend \Validus\Rules\Base class, and implement
// two methods: applyTo($targetValue) and setDefaultErrorMessage()

    class MyCustomRule extends \Validus\Rules\Base {

        public function applyTo($targetValue) {
            return (
                    ($targetValue >= 10) &
                    ($targetValue <= 30) &
                    ($targetValue % 2 == 0)
                    );
        }

        public function setDefaultErrorMessage() {
            $this->setErrorMessage("Hello, i'm custom error message!");
        }

    }

// Instantiate validator
    $validation = new \Validus\Validus();

// Apply MyCustomRule instance to container's 'age' field
// we'll leave condition empty, because there's none in that case
    $validation->addRule('age', new MyCustomRule(null, 'age', "Must be in range 10..30 and also even"));

// Instantiate target
    $user['name'] = 'John';
    $user['age'] = '31';
    if ($validation->fails($user)) {
        print_r($validation->errorsFor('age'));
    } else {
        echo "Validation passed\n";
    }
}


// If you want to call $validation->on('age')->mycustomrule()
// your rule must be defined under \Validus\Rules namespace

namespace Validus\Rules {

    class NewCustomRule extends \MyCustomRule {

        public function setDefaultErrorMessage() {
            $this->setErrorMessage("Hi, i'm new CustomRule error message");
        }

    }

}

namespace {
    $user['age'] = '27';
    $validation->on('age')->newcustomrule($condition = null);
    if ($validation->fails($user)) {
        print_r($validation->errorsFor('age'));
    } else {
        echo "Validation passed\n";
    }
}