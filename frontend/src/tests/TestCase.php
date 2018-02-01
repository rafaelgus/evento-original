<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function set($subject, $propertyName, $value)
    {
        $property = $this->getPropertyOf($subject, $propertyName);
        if ($property->isStatic()) {
            $property->setValue($value);
        } else {
            $property->setValue($subject, $value);
        }
    }

    public function getPropertyOf($subject, $propertyName)
    {
        $reflectionClass = new ReflectionClass($subject);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }
}
