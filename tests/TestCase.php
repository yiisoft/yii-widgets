<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Composer\Config\Builder;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Asset\AssetBundle;
use Yiisoft\Asset\AssetManager;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\Di\Container;
use Yiisoft\View\WebView;
use Yiisoft\Widget\WidgetFactory;

abstract class TestCase extends BaseTestCase
{
    protected Aliases $aliases;
    protected CacheInterface $cache;
    private ContainerInterface $container;
    protected WebView $webView;

    protected function setUp(): void
    {
        parent::setUp();

        $config = require Builder::path('tests');

        $this->container = new Container($config);

        $this->aliases = $this->container->get(Aliases::class);
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
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return void
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
     *
     * @return void
     */
    protected function assertSameIgnoringSlash(string $expected, string $actual): void
    {
        $expected = str_replace(['/', '\\'], '/', $expected);
        $actual = str_replace(['/', '\\'], '/', $actual);
        $this->assertSame($expected, $actual);
    }
}
