<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Cache\Cache;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Test\Support\EventDispatcher\SimpleEventDispatcher;
use Yiisoft\Test\Support\SimpleCache\MemorySimpleCache;
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

        $this->container = new SimpleContainer($this->config());

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

    private function config(): array
    {
        return [
            Aliases::class => new Aliases([
                '@root' => __DIR__,
                '@public' => '@root/public',
            ]),

            CacheInterface::class => new Cache(new MemorySimpleCache()),

            WebView::class => new WebView(
                __DIR__ . '/public/view',
                new SimpleEventDispatcher(),
            ),
        ];
    }
}

namespace Yiisoft\Html;

function hrtime(bool $getAsNumber = false): void
{
}
