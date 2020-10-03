# DI Container

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)


This class calls another class method, resolves constructor & method dependency on the fly.


## Prerequisites

Language: PHP 7.0/+

## Installation

```
composer require abmmhasan/di-container
```

## Usage

### Example 01

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
* Pass the class with full namespace as first parameter
* In second parameter pass the value as comma separated which will be
* resolved to class __construct
*/
$class = new Container('TestClass',23); // TestClass: Class we resolving, 23: $id param
/**
* Afterwards we call any methods of that class
* 'getRequest()' is a method of 'TestClass' that we are calling.
* Extra parameter can be sent as comma separated, which will be resolved to given method
*/
$value = $class->getRequest(34,43);
```

### Example 02

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
$class = new Container('TestClass'); // TestClass: Class we resolving
/**
* Same as above
*/
$value = $class->getRequest();
```

## Support

Having trouble? Create an issue!
