<?php
namespace EventoOriginal\Core\Tests\Integration;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use EventoOriginal\Core\Tests\Integration\Fixtures\BrandsFixture;
use EventoOriginal\Core\Tests\Integration\Fixtures\CategoriesFixture;
use EventoOriginal\Core\Tests\Integration\Fixtures\TagsFixture;
use EventoOriginal\Core\Tests\Integration\Utils\DbManager;

class FixturesLoader
{
    protected $dbManager;
    protected static $schemaLoaded = false;

    public function __construct(DbManager $dbManager, bool $loadSchema)
    {
        $this->dbManager = $dbManager;
        if ($loadSchema && !static::$schemaLoaded) {
            static::$schemaLoaded = true;
            $this->dbManager->dropSchema();
            $this->dbManager->createSchema();
        }
    }

    public function load()
    {
        $loader = new Loader();
        $loader->addFixture(new BrandsFixture());
        $loader->addFixture(new CategoriesFixture());
        $loader->addFixture(new TagsFixture());
        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->dbManager->getEntityManager(), $purger);
        $executor->execute($loader->getFixtures());
    }
}
