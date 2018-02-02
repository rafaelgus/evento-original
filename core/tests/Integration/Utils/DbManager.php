<?php
namespace EventoOriginal\Core\Tests\Integration\Utils;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class DbManager
{
    private static $instance = null;

    public static function getInstance(EntityManager $em)
    {
        if (empty(static::$instance)) {
            return new DbManager(($em));
        } else {
            return static::$instance;
        }
    }

    protected $em;
    protected $connection;

    protected function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->connection = $em->getConnection();
        $this->doctrineSchemaTool = new SchemaTool($this->em);
    }

    /**
     * Create database
     */
    public function createSchema()
    {
        $metadatas = $this->getMetadatas();

        if (!empty($metadatas)) {
            $tool = new SchemaTool($this->em);
            $tool->createSchema($metadatas);
        } else {
            throw new SchemaException('No Metadata Classes to process.');
        }
    }

    /**
     * Destroy database
     */
    public function dropSchema()
    {
        $metaDataFactory = $this->em->getMetadataFactory();
        $classes = $metaDataFactory->getAllMetadata();
        $this->doctrineSchemaTool->dropSchema($classes);
    }

    /**
     * Overwrite this method to get specific metadatas.
     *
     * @return array
     */
    protected function getMetadatas()
    {
        return $this->em->getMetadataFactory()->getAllMetadata();
    }

    public function getEntityManager()
    {
        return $this->em;
    }
}
