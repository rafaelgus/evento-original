#!/usr/bin/env php
<?php
require __DIR__ . '/../../../../../api/src/config/bootstrap.php';
use Flaubert\Persistence\Doctrine\Migrations\MigrationsConsoleApp;

$cli = $container->get(MigrationsConsoleApp::class);

$cli->run();
