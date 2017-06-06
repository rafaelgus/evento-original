<?php
use Doctrine\Common\Annotations\AnnotationRegistry;

define('ROOT_DIR', realpath(__DIR__ . '/../../../'));
define('API_DIR', realpath(__DIR__ . '/../'));
define('CORE_DIR', realpath(__DIR__ . '/../../../core/src'));

require ROOT_DIR . '/core/vendor/autoload.php';
require ROOT_DIR . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(ROOT_DIR);
$dotenv->load();

AnnotationRegistry::registerAutoloadNamespace(
    'Gedmo\Mapping\Annotation',
    CORE_DIR . '/vendor/gedmo'
);

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(API_DIR . '/config/di.php');

$container = $builder->build();
