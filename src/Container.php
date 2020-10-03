<?php

/**
 * @link https://github.com/abmmhasan/DI-Container
 */

namespace AbmmHasan\DIContainer;

/**
 * The Container class can inject dependency while calling class methods (for both method & constructor)
 *
 * Usage examples can be found in the included README file, and all methods
 * should have adequate documentation to get you started.
 *
 * @author      A. B. M. Mahmudul Hasan <abmmhasan346@gmail.com>
 * @copyright   Copyright (c), 2020 A. B. M. Mahmudul Hasan
 * @license     MIT public license
 */

class Container
{
    private $class;
    private $constructorParams;

    /**
     * Set Class & Constructor parameters.
     *
     * @param $class
     * @param mixed ...$parameters
     */
    public function __construct($class, ...$parameters)
    {
        $this->class = $class;
        $this->constructorParams = $parameters;
    }

    /**
     * Class Method Resolver
     *
     * @param $method
     * @param $params
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call($method, $params)
    {
        $constructor = (new \ReflectionClass($this->class))->getConstructor();
        if (is_null($constructor)) {
            return (new $this->class())->$method(
                ...
                ($this->resolveParameters(new \ReflectionMethod($this->class, $method), $params))
            );
        }
        return (new $this->class(
            ...
            $this->resolveParameters($constructor, $this->constructorParams)
        ))->$method(
            ...
            ($this->resolveParameters(new \ReflectionMethod($this->class, $method), $params))
        );
    }

    /**
     * Resolve Function parameter
     *
     * @param array $parameters
     * @param \ReflectionFunctionAbstract $reflector
     * @return array
     * @throws \ReflectionException
     */
    private function resolveParameters(\ReflectionFunctionAbstract $reflector, array $parameters)
    {
        $instanceCount = 0;
        $values = array_values($parameters);
        $skipValue = new \stdClass();
        foreach ($reflector->getParameters() as $key => $parameter) {
            $instance = $this->resolveDependency($parameter, $parameters, $skipValue);
            if ($instance !== $skipValue) {
                $instanceCount++;
                array_splice(
                    $parameters,
                    $key,
                    0,
                    [$instance]
                );
            } elseif (!isset($values[$key - $instanceCount]) &&
                $parameter->isDefaultValueAvailable()) {
                array_splice(
                    $parameters,
                    $key,
                    0,
                    [$parameter->getDefaultValue()]
                );
            }
        }
        return $parameters;
    }

    /**
     * Resolve parameter dependency
     *
     * @param \ReflectionParameter $parameter
     * @param $parameters
     * @param $skipValue
     * @return object|null
     */
    private function resolveDependency(\ReflectionParameter $parameter, $parameters, $skipValue)
    {
        $class = $parameter->getClass();
        if ($class && !$this->alreadyExist($class->name, $parameters)) {
            return $parameter->isDefaultValueAvailable()
                ? null
                : $class->newInstance();
        }
        return $skipValue;
    }

    /**
     * Check if parameter already resolved
     *
     * @param $class
     * @param array $parameters
     * @return bool
     */
    private function alreadyExist($class, array $parameters)
    {
        foreach ($parameters as $value) {
            if ($value instanceof $class) {
                return !is_null($value);
            }
        }
    }
}