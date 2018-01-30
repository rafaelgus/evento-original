#!/usr/bin/env php
<?php
require __DIR__ . '/../../../../../frontend/src/bootstrap/autoload.php';
use Flaubert\Persistence\Doctrine\Migrations\MigrationsConsoleApp;

$cli = app()->make(MigrationsConsoleApp::class);

$cli->run();
