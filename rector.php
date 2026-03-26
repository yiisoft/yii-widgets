<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpSets(php81: true)
    ->withSkip([
        ClassPropertyAssignToConstructorPromotionRector::class => [
            __DIR__ . '/src/ContentDecorator.php',
        ],
    ])
    ->withRules([
        InlineConstructorDefaultToPropertyRector::class,
    ]);
