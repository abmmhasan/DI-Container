<?php

use AbmmHasan\DIContainer\Container;

if (!function_exists('initiate')) {
    /**
     * Create a collection from the given value.
     *
     * @param $classOrClosure
     * @param mixed ...$parameters
     * @return Container
     */
    function initiate($classOrClosure, ...$parameters)
    {
        return new Container($classOrClosure, ...$parameters);
    }
}