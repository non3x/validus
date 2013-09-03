<?php

error_reporting(E_STRICT | E_ALL);
ini_alter('display_errors', 'on');

include 'SplClassLoader.php';
$classLoader = new SplClassLoader('Validus', dirname(__FILE__) . '/../src');
$classLoader->register();

// Instantiate validator
$validation = new \Validus\Validus();

$target = new stdClass();
$target->name = 'Hal';
$target->invalidName = 'Hal9000';

$validation->on('name')->regexp('/^([a-zA-Z]*)$/', "Can not contain numbers, only characters a-zA-Z");
$validation->on('invalidName')->sameAs('name');

$validation->fails($target);
print_r($validation->errors());