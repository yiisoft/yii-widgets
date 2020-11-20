<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Cache\ArrayCache;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\EventDispatcher\Dispatcher\Dispatcher;
use Yiisoft\EventDispatcher\Provider\Provider;
use Yiisoft\Log\Logger;
use Yiisoft\View\Theme;
use Yiisoft\View\WebView;

return [
    Aliases::class => [
        '@root' => dirname(__DIR__, 1),
        '@public' => '@root/tests/public',
        '@basePath' => '@public/assets',
    ],

    CacheInterface::class => static function () {
        return new Cache(new ArrayCache());
    },

    EventDispatcherInterface::class => static function (ContainerInterface $container) {
        return new Dispatcher($container->get(Provider::class));
    },

    LoggerInterface::class => static function (ContainerInterface $container) {
        return new Logger();
    },

    WebView::class => static function (ContainerInterface $container) {
        $aliases = $container->get(Aliases::class);
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $theme = $container->get(Theme::class);
        $logger = $container->get(LoggerInterface::class);

        return new WebView($aliases->get('@view'), $theme, $eventDispatcher, $logger);
    },
];
