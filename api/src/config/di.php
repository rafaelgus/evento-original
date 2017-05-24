<?php

use EventoOriginal\Core\Persistence\Repositories;
use EventoOriginal\Core\Entities;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;
use Interop\Container\ContainerInterface;

return [
    EntityManager::class => function () {
        $paths = [CORE_DIR . '/Entities'];

        $isDevMode = getenv('DEV_MODE') ?: false;


        $cache = new Doctrine\Common\Cache\ArrayCache;

        $annotationReader = new Doctrine\Common\Annotations\AnnotationReader;
        $cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
            $annotationReader,
            $cache
        );

        $driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();

        Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
            $driverChain,
            $cachedAnnotationReader
        );

        $annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
            $cachedAnnotationReader,
            $paths // paths to look in
        );

        $driverChain->addDriver($annotationDriver, 'EventoOriginal\Core\Entities');

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $config->setProxyDir(ROOT_DIR . '/frontend/src/storage/proxies/');
        $config->setMetadataDriverImpl($driverChain);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        $evm = new Doctrine\Common\EventManager();

        $translatableListener = new Gedmo\Translatable\TranslatableListener;

        $translatableListener->setTranslatableLocale('es');
        $translatableListener->setDefaultLocale('es');
        $translatableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($translatableListener);

        $evm->addEventSubscriber(new Doctrine\DBAL\Event\Listeners\MysqlSessionInit());

        $dbParams = [
            'driver' => 'pdo_mysql',
            'host' => getenv('DB_HOST') ?: 'localhost',
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
        ];

        return EntityManager::create($dbParams, $config, $evm);
    },
    Repositories\ColorRepository::class => DI\factory(function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository(Entities\Color::class);
    }),
    TranslationRepository::class => DI\Factory(function (ContainerInterface $c) {
        return $c->get(EntityManager::class)->getRepository('Gedmo\Translatable\Entity\Translation');
    }),
];
