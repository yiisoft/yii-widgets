<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Cache\ArrayCache;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\Di\Container;
use Yiisoft\EventDispatcher\Dispatcher\Dispatcher;
use Yiisoft\EventDispatcher\Provider\Provider;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Log\Logger;
use Yiisoft\View\Theme;
use Yiisoft\View\WebView;
use Yiisoft\Widget\WidgetFactory;

abstract class TestCase extends BaseTestCase
{
    protected CacheInterface $cache;
    private ContainerInterface $container;
    protected WebView $webView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container($this->config());

        $this->cache = $this->container->get(CacheInterface::class);
        $this->webView = $this->container->get(WebView::class);

        WidgetFactory::initialize($this->container, []);
    }

    protected function tearDown(): void
    {
        unset($this->container, $this->webView);
        parent::tearDown();
    }

    /**
     * Asserting two strings equality ignoring line endings.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertEqualsWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Asserting same ignoring slash.
     *
     * @param string $expected
     * @param string $actual
     */
    protected function assertSameIgnoringSlash(string $expected, string $actual): void
    {
        $expected = str_replace(['/', '\\'], '/', $expected);
        $actual = str_replace(['/', '\\'], '/', $actual);
        $this->assertSame($expected, $actual);
    }

    public function config(): array
    {
        return [
            Aliases::class => [
                '__class' => Aliases::class,
                '__construct()' => [
                    [
                        '@root' => __DIR__,
                        '@public' => '@root/public',
                    ],
                ],
            ],

            Cache::class => [
                '__class' => Cache::class,
                '__construct()' => [
                    Reference::to(ArrayCache::class),
                ],
            ],

            CacheInterface::class => Cache::class,

            ListenerProviderInterface::class => Provider::class,

            EventDispatcherInterface::class => Dispatcher::class,

            LoggerInterface::class => Logger::class,

            WebView::class => [
                '__class' => WebView::class,
                '__construct()' => [
                    __DIR__ . '/public/view',
                    Reference::to(Theme::class),
                    Reference::to(EventDispatcherInterface::class),
                    Reference::to(LoggerInterface::class),
                ],
            ],
        ];
    }
}
