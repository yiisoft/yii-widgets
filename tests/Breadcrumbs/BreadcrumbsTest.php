<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;
use InvalidArgumentException;

final class BreadcrumbsTest extends TestCase
{
    use TestTrait;

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb external">
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->attributes(['class' => 'breadcrumb external'])
                ->homeItem(null)
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->render(),
        );
    }

    public function testEmptyLinks(): void
    {
        $this->assertEmpty(Breadcrumbs::widget()->render());
    }

    public function testHomeItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li>home-link</li>
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->homeItem(['label' => 'home-link'])
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->render(),
        );
    }

    public function testIdEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Breadcrumbs::widget()->id('');
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb" id="my-breadcrumbs">
            <li><a href="/">Home</a></li>
            <li class="active">My Home Page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->id('my-breadcrumbs')
                ->items(['My Home Page'])
                ->render(),
        );
    }

    public function testItems(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">My Home Page</li>
            <li class="active">https://my.example.com/yii/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->items(['label' => 'My Home Page', 'url' => 'https://my.example.com/yii/link/page'])
                ->render(),
        );
    }

    public function testItemsWithTemplate(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="https://my.example.com/yii/link/page">Link</a></li>
            <span>Text</span>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->items(
                    [
                        ['label' => 'Link', 'url' => 'https://my.example.com/yii/link/page'],
                        ['label' => 'Text', 'template' => "<span>{link}</span>\n"],
                    ],
                )
                ->render(),
        );
    }

    public function testRenderItemLabelOnlyEncodeLabelFalse(): void
    {
        $this->assertSame(
            "<li>My-<br>Test-Label</li>\n",
            Breadcrumbs::widget()
                ->activeItemTemplate("<li>{link}</li>\n")
                ->homeItem(null)
                ->items([['label' => 'My-<br>Test-Label', 'encode' => false]]) // encode label false
                ->tag('')
                ->render(),
        );
    }

    public function testRenderItemEncodeKeyDoesNotLeakToAttributes(): void
    {
        $result = Breadcrumbs::widget()
            ->homeItem(null)
            ->items([['label' => 'Label', 'url' => '/path', 'encode' => false]])
            ->tag('')
            ->render();

        $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*\sencode=/', $result);
        $this->assertStringContainsString('<a href="/path">', $result);
    }

    public function testRenderItemLabelOnlyEncodeLabelTrue(): void
    {
        $this->assertSame(
            '<li>My-&lt;br&gt;Test-Label</li>',
            Breadcrumbs::widget()
                ->activeItemTemplate('<li>{link}</li>')
                ->homeItem(null)
                ->items(['label' => 'My-<br>Test-Label'])
                ->tag('')
                ->render(),
        );
    }

    public function testTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="breadcrumb">
            <a href="/">Home</a>
            My Home Page
            http://my.example.com/yii2/link/page
            </div>
            HTML,
            Breadcrumbs::widget()
                ->activeItemTemplate("{link}\n")
                ->attributes(['class' => 'breadcrumb'])
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->itemTemplate("{link}\n")
                ->tag('div')
                ->render(),
        );
    }

    public function testWithoutHomeItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->homeItem(null)
                ->items([
                    'label' => 'My Home Page',
                    'url' => 'http://my.example.com/yii2/link/page',
                ])
                ->render(),
        );
    }

    public function testContainer(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav>
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testContainerDisabled(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->container(false)
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="Breadcrumb">
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->containerAttributes(['aria-label' => 'Breadcrumb'])
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="breadcrumb-nav">
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->containerClass('breadcrumb-nav')
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testContainerClassMergesWithAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="base breadcrumb-nav" aria-label="Breadcrumb">
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->containerAttributes(['class' => 'base', 'aria-label' => 'Breadcrumb'])
                ->containerClass('breadcrumb-nav')
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testContainerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Current Page</li>
            </ul>
            </div>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->containerTag('div')
                ->items(['Current Page'])
                ->render(),
        );
    }

    public function testJsonLd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="https://example.com/category">Category</a></li>
            <li class="active">Current Page</li>
            </ul>
            <script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"\/"},{"@type":"ListItem","position":2,"name":"Category","item":"https:\/\/example.com\/category"},{"@type":"ListItem","position":3,"name":"Current Page"}]}</script>
            HTML,
            Breadcrumbs::widget()
                ->jsonLd(true)
                ->items([
                    ['label' => 'Category', 'url' => 'https://example.com/category'],
                    'Current Page',
                ])
                ->render(),
        );
    }

    public function testJsonLdWithoutHomeItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="https://example.com/category">Category</a></li>
            <li class="active">Current Page</li>
            </ul>
            <script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Category","item":"https:\/\/example.com\/category"},{"@type":"ListItem","position":2,"name":"Current Page"}]}</script>
            HTML,
            Breadcrumbs::widget()
                ->homeItem(null)
                ->jsonLd(true)
                ->items([
                    ['label' => 'Category', 'url' => 'https://example.com/category'],
                    'Current Page',
                ])
                ->render(),
        );
    }

    public function testRenderJsonLd(): void
    {
        $this->assertSame(
            '<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Category","item":"https:\/\/example.com\/category"},{"@type":"ListItem","position":2,"name":"Current Page"}]}</script>',
            Breadcrumbs::widget()
                ->homeItem(null)
                ->items([
                    ['label' => 'Category', 'url' => 'https://example.com/category'],
                    'Current Page',
                ])
                ->renderJsonLd(),
        );
    }

    public function testRenderJsonLdSkipsEmptyItems(): void
    {
        $this->assertSame(
            '<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Page"}]}</script>',
            Breadcrumbs::widget()
                ->homeItem(null)
                ->items([[], 'Page'])
                ->renderJsonLd(),
        );
    }

    public function testRenderJsonLdSkipsItemsWithoutLabel(): void
    {
        $this->assertSame(
            '<script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Page"}]}</script>',
            Breadcrumbs::widget()
                ->homeItem(null)
                ->items([['url' => '/no-label'], 'Page'])
                ->renderJsonLd(),
        );
    }

    public function testContainerWithJsonLd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="Breadcrumb">
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="https://example.com/category">Category</a></li>
            <li class="active">Current Page</li>
            </ul>
            </nav>
            <script type="application/ld+json">{"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"\/"},{"@type":"ListItem","position":2,"name":"Category","item":"https:\/\/example.com\/category"},{"@type":"ListItem","position":3,"name":"Current Page"}]}</script>
            HTML,
            Breadcrumbs::widget()
                ->container(true)
                ->containerAttributes(['aria-label' => 'Breadcrumb'])
                ->jsonLd(true)
                ->items([
                    ['label' => 'Category', 'url' => 'https://example.com/category'],
                    'Current Page',
                ])
                ->render(),
        );
    }
}
