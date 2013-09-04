<?php

error_reporting(E_STRICT | E_ALL);
ini_alter('display_errors', 'on');

//include 'SplClassLoader.php';
//$classLoader = new SplClassLoader('Validus', dirname(__FILE__) . '/../src');
//$classLoader->register();

require '../vendor/autoload.php';

// Instantiate validator
$validation = new \Validus\Validus();

// let's say we have this simple «model» container
// which can be object with accessible fields or just 
// php asssociative array.

$user = new stdClass();
$user->name = 'John';
$user->surname = 'Doe';
$user->password = 'abr0cadabr0';
$user->age = 35;
$user->email = 'john@doe.com';

// First of all we want none of our fields to be empty,
// so just apply notEmpty (i.e Rules\NotEmpty object)
// to the whole container, which is StdObject in our case.
$validation->entire($user)->notempty();

// Name and Surname must be from 3 to 32 characters long
// Please note, that this will be equivalent to
// $validation->on('name')->minlength(3)->maxlength(32);
// $validation->on('surname')->sameAs('name');
$validation
        ->on(array('name', 'surname'))
        ->minlength(3)
        ->maxlength(32);

// Age must be between 30 and 40 (just for the sake of demonstration)
$validation
        ->on('age')
        ->gt(30)
        ->lt(40);

// Validate email
$validation
        ->on('email')
        ->email(null, 'Is not in valid format, must complain with RFC 2821');

if ($validation->fails($user)) {
    print_r($validation->errors());
} else {
    echo "Yay, \$user is valid!\n";
}

// Ok, you should see success message.
// Let's create another object, with invalid values
$invalidUser = new stdClass();
$invalidUser->name = 'Jo';
$invalidUser->surname = 'Do';
$invalidUser->password = null;
$invalidUser->age = 29;
$invalidUser->email = 'john@doe';

// Apply same validation rules to invalidUser
if ($validation->fails($invalidUser)) {
    print_r($validation->errors());
} else {
    echo "Yay, \$invalidUser is valid!\n";
}