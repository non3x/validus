<?php

error_reporting(E_STRICT | E_ALL);
ini_alter('display_errors', 'on');

require '../vendor/autoload.php';

// Instantiate validator
$validation = new \Validus\Validus();

// To expose closure rule functionality let's say we want to 
// parse "money" property of container and compare result
// to some external values

$target = array('money' => '100 USD', 'moreMoney' => '5 EUR');
$currency = 'USD';
$minimumAmount = '20';

$validation->on('money')->closure(function($money) use ($currency, $minimumAmount) {
            $_t = explode(' ', $money);
            if (($_t[0] >= $minimumAmount) and ($_t[1] == $currency)) {
                return true;
            }
            return false;
        });

$validation->on('moreMoney')->sameAs('money');

if ($validation->fails($target)) {
    print_r($validation->errors());
}

// As you can see validation fails on moreMoney field, which actually 
// does not satisfy our global criteria (min 20 USD)