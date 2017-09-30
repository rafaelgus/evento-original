<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use ReflectionClass;
use Illuminate;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    private $container;

    const SERVICE_CORE_DIR = 'Autoahora\\Core\\Services\\';

    public function setUp()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $this->container = $app;
        parent::setUp();
    }

    public function getService(string $servicePrefix)
    {
        return $this->container->make(self::SERVICE_CORE_DIR . $servicePrefix);
    }

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
