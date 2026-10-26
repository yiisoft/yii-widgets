<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

$config = (new Configuration())
    ->disableComposerAutoloadPathScan()
    ->setFileExtensions(['php'])
    ->addPathToScan(__DIR__ . '/src', isDev: false)
    ->addPathToScan(__DIR__ . '/tests', isDev: true);

// These functions are defined in vendor/yiisoft/html/src/test-functions.php, which is loaded
// manually in tests/bootstrap.php and is not part of composer's "files" autoload, so the analyser
// cannot find their declarations and reports them as unknown functions.
$config->ignoreUnknownFunctions([
    'Yiisoft\Html\IdGenerator\disableSeed',
    'Yiisoft\Html\IdGenerator\enableSeed',
    'Yiisoft\Html\IdGenerator\reset',
]);

return $config;
