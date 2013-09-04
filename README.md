##Introduction
Validus is a PHP library for object/array data validation. Main goal was to provide
users with easy to use and extend software, which can be easily integrated in their
own projects. Validus is relying on modern PHP (>=5.3.0) functionality and concepts, 
such as namespaces and PSR-0 autoloading.

##Base concepts
+ Complaint with FIG-standards and coding styles
+ Object oriented (validation rules are objects too)
+ Flexbile and easy to use

##How to use
Given simple std object, such as

```php
$user = new stdClass();
$user->name = 'John';
$user->age = 25;
$user->email = 'john@doe.com';
$user->secondEmail = 'john@gmail.com';
```
and Validus instantiated (don't forget autoloading)

```php
$validation = new \Validus\Validus();
```

you can apply validation rules with on(), sameAs() or entire() methods:

- on($property) or on(array($prop1, $prop2)) - bind validation rules to specified properties

```php
$validation->on('age')->lt(30, "Age can't exceed 30 years");
$validation->on('email')->email(null, "must complain with RFC 2821");
```

- sameAs($property) - copy validation rules from one property to another

```php
$validation->on('secondEmail')->sameAs('email');
```

- entire($target) - apply rules to all target's properties

```php
$validation->entire($user)->notempty();
```

After that, validation check is straight forward:

```php
if($validation->fails()){
    print_r($validation->errors());
}
else{
    echo "User is valid\n";
}
```

##Advanced usage
Please refer to examples code for implementation details, here's short
description of more advanced features that are available:
+ You can define closure as validation rule

```php
$validation->on('age')->closure(function($age){...});
```

+ Regular expressions are supported

```php
$validation->on('name')->regexp('/^([a-zA-Z]*)$/', "Only characters a-zA-Z");
```

+ Custom rules classes/objects that you can attach via addRule() method.