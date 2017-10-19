<?php
namespace EventoOriginal\Core\Tests\Integration;

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use EventoOriginal\Core\Tests\Integration\Utils\DbManager;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class BaseTest extends TestCase
{
    /**
     * @var \DI\Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    public function setUp()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(API_DIR . '/config/di.php');
        $this->container = $builder->build();
        $this->container->injectOn($this);

        parent::setUp();

        $this->em = $this->container->get(EntityManager::class);
        $this->prepareForTests();
    }

    /**
     * Migrate the database
     */
    private function prepareForTests()
    {
        $this->dbSeed();
    }

    protected function dbSeed()
    {
        $dbManager = DbManager::getInstance($this->em);
        $fixturesLoader = new FixturesLoader($dbManager, true);
        $fixturesLoader->load();
    }

    protected function getService($servicePrefix)
    {
        return $this->container->get('EventoOriginal\\Core\\Services\\' . $servicePrefix . 'Service');
    }

    protected function get($resource)
    {
        return $this->container->get($resource);
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
