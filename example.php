<?php


use AbmmHasan\DIContainer\Container;

class TestClass
{
    public function __construct(Sample1 $sample, $id)
    {
        print_r([$sample->all(),$id]);
    }

    public function getRequest(Sample2 $sample, $pid, $sid)
    {
        return [$sample->all(),$pid,$sid];
    }
}

$class = new Container('TestClass',23);
$value = $class->getRequest(34,43);
print_r($value);

