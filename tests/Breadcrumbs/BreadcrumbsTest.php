<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

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

    public function testFromMenu(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Home', 'link' => '/'],
                ['label' => 'About', 'link' => '/about'],
            ])
            ->currentPath('/about');

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">About</li>
            </ul>
            HTML,
            Breadcrumbs::fromMenu($menu)->render(),
        );
    }

    public function testFromMenuChaining(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'About', 'link' => '/about', 'active' => true],
            ]);

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="custom">
            <li class="active">About</li>
            </nav>
            HTML,
            Breadcrumbs::fromMenu($menu)
                ->homeItem(null)
                ->attributes(['class' => 'custom'])
                ->tag('nav')
                ->render(),
        );
    }

    public function testFromMenuWithDeepNesting(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Level 1', 'link' => '/l1', 'items' => [
                    ['label' => 'Level 2', 'link' => '/l2', 'items' => [
                        ['label' => 'Level 3', 'link' => '/l3'],
                    ]],
                ]],
            ])
            ->currentPath('/l3');

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/l1">Level 1</a></li>
            <li><a href="/l2">Level 2</a></li>
            <li class="active">Level 3</li>
            </ul>
            HTML,
            Breadcrumbs::fromMenu($menu)->render(),
        );
    }

    public function testFromMenuWithEncodeFalse(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => '<b>Bold</b>', 'link' => '/bold', 'encode' => false, 'active' => true],
            ]);

        $this->assertSame(
            "<li class=\"active\"><b>Bold</b></li>\n",
            Breadcrumbs::fromMenu($menu)->homeItem(null)->tag('')->render(),
        );
    }

    public function testFromMenuWithExplicitActive(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Home', 'link' => '/'],
                ['label' => 'About', 'link' => '/about', 'active' => true],
            ]);

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">About</li>
            </ul>
            HTML,
            Breadcrumbs::fromMenu($menu)->render(),
        );
    }

    public function testFromMenuWithInvisibleItem(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Products', 'link' => '/products', 'items' => [
                    ['label' => 'Hidden', 'link' => '/products/hidden', 'visible' => false],
                    ['label' => 'Widgets', 'link' => '/products/widgets'],
                ]],
            ])
            ->currentPath('/products/widgets');

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/products">Products</a></li>
            <li class="active">Widgets</li>
            </ul>
            HTML,
            Breadcrumbs::fromMenu($menu)->render(),
        );
    }

    public function testFromMenuWithNestedItems(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Home', 'link' => '/'],
                ['label' => 'Products', 'link' => '/products', 'items' => [
                    ['label' => 'Widgets', 'link' => '/products/widgets'],
                    ['label' => 'Gadgets', 'link' => '/products/gadgets'],
                ]],
            ])
            ->currentPath('/products/widgets');

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/products">Products</a></li>
            <li class="active">Widgets</li>
            </ul>
            HTML,
            Breadcrumbs::fromMenu($menu)->render(),
        );
    }

    public function testFromMenuWithNoActiveItem(): void
    {
        $menu = Menu::widget()
            ->items([
                ['label' => 'Home', 'link' => '/'],
                ['label' => 'About', 'link' => '/about'],
            ])
            ->currentPath('/unknown');

        $this->assertEmpty(Breadcrumbs::fromMenu($menu)->render());
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
}
