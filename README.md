# DI Container

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)


This library, resolves constructor & method dependency on the fly (also for closure). Check examples below.

### Repository archived/abandoned.

Suggested to use https://github.com/abmmhasan/OOF instead!

## Prerequisites

Language: PHP 7.0/+

## Installation

```
composer require abmmhasan/di-container
```

## Usage

### Example 01: With additional parameter

```php
/**
* A test class where we resolving dependency for
* both constructor and defined method
*/
class TestClass
{
    public function __construct(Sample1 $sample, $id)
    {
        return [$sample->all(),$id];
    }

    public function getRequest(Sample2 $sample, $pid, $sid)
    {
        return [$sample->all(),$pid,$sid];
    }
}

/**
* Pass the class as first parameter
* In second parameter pass the value as comma separated which will be
* resolved to class __construct
*/
$class = new Container(TestClass::class,23); // TestClass: Class we resolving, 23: $id param
// or,
$class = initiate(TestClass::class,23);
/**
* Afterwards we call any methods of that class
* 'getRequest()' is a method of 'TestClass' that we are calling.
* Extra parameter can be sent as comma separated, which will be resolved to given method
*/
$value = $class->getRequest(34,43);
```

### Example 02: Without additional parameter

```php
/**
* A test class where we resolving dependency for
* both constructor and defined method
*/
class TestClass
{
    public function __construct(Sample1 $sample)
    {
        return [$sample->all()];
    }

    public function getRequest(Sample2 $sample)
    {
        return [$sample->all()];
    }
}

/**
* Only send parameter if required
*/
$class = new Container(TestClass::class); // TestClass: Class we resolving
// or,
$class = initiate(TestClass::class);
/**
* Same as above
*/
$value = $class->getRequest();
```

### Example 03: Closure

```php
$myClosure = function (Request $request, $test, $rest) {
                     print_r($request);
                     echo "I'm inside[$test,$rest]";
                 };
$class = new Container($myClosure, 23, 34); // Pass the closure
// or,
$class = initiate($myClosure, 23, 34);
```

### Example 04: I don't need any dependency resolution

```php
/**
* From example 02 (same for 01 but not applicable for 03: Closure)
 */
$class = new Container(TestClass::class); // TestClass: Class we resolving
// or,
$class = initiate(TestClass::class);
/**
* Add this additional call before doing any method call
*/
$class->_noInject();
/**
* Now do calls as usual
 */
$value = $class->getRequest();
```

## Support

Having trouble? Create an issue!
