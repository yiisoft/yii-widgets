<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\Breadcrumbs;

/**
 * BreadcrumbsTest.
 */
final class BreadcrumbsTest extends TestCase
{
    public function testHomeLinkTrue(): void
    {
        $html = Breadcrumbs::widget()
            ->links([
                'label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page',
            ])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li><a href=\"/\">Home</a></li>\n" .
        "<li class=\"active\">My Home Page</li>\n" .
        "<li class=\"active\">http://my.example.com/yii2/link/page</li>\n" .
        '</ul>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testEmptyLinks(): void
    {
        $html = Breadcrumbs::widget()->render();

        $this->assertEmpty($html);
    }

    public function testHomeLinkFalse(): void
    {
        $html = Breadcrumbs::widget()
            ->homeLink(false)
            ->links([
                'label' => 'My Home Page',
                'url' => 'http://my.example.com/yii2/link/page',
            ])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li class=\"active\">My Home Page</li>\n" .
            "<li class=\"active\">http://my.example.com/yii2/link/page</li>\n" .
            '</ul>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testHomeUrlLink(): void
    {
        $html = Breadcrumbs::widget()
            ->homeLink(false)
            ->homeUrlLink(['label' => 'home-link'])
            ->links(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li>home-link</li>\n" .
            "<li class=\"active\">My Home Page</li>\n" .
            "<li class=\"active\">http://my.example.com/yii2/link/page</li>\n" .
            '</ul>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testRenderItemException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $html = Breadcrumbs::widget()
            ->homeLink(false)
            ->links([
                'url' => 'http://my.example.com/yii2/link/page',
            ])
            ->render();
    }

    public function testRenderItemLabelOnlyEncodeLabelFalse(): void
    {
        $html = Breadcrumbs::widget()
            ->activeItemTemplate("<li>{link}</li>\n")
            ->encodeLabels(false)
            ->homeLink(false)
            ->links(['label' => 'My-<br>Test-Label'])
            ->options([])
            ->tag('')
            ->render();

        $this->assertEquals("<li>My-<br>Test-Label</li>\n", $html);
    }

    public function testRenderItemLabelOnlyEncodeLabelTrue(): void
    {
        $html = Breadcrumbs::widget()
            ->activeItemTemplate("<li>{link}</li>\n")
            ->homeLink(false)
            ->links(['label' => 'My-<br>Test-Label'])
            ->options([])
            ->tag('')
            ->render();

        $this->assertEquals("<li>My-&lt;br&gt;Test-Label</li>\n", $html);
    }

    public function testOptions(): void
    {
        $html = Breadcrumbs::widget()
            ->homeLink(false)
            ->links(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
            ->options(['class' => 'breadcrumb external'])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb external\"><li class=\"active\">My Home Page</li>\n";

        $this->assertStringContainsString($expectedHtml, $html);
    }

    public function testTag(): void
    {
        $html = Breadcrumbs::widget()
            ->activeItemTemplate("{link}\n")
            ->itemTemplate("{link}\n")
            ->homeLink(true)
            ->links(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
            ->options(['class' => 'breadcrumb'])
            ->tag('div')
            ->render();

        $expectedHtml = "<div class=\"breadcrumb\"><a href=\"/\">Home</a>\n" .
            "My Home Page\n" .
            "http://my.example.com/yii2/link/page\n" .
            '</div>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testImmutability(): void
    {
        $widget = Breadcrumbs::widget();

        $this->assertNotSame($widget, $widget->tag('ul'));
        $this->assertNotSame($widget, $widget->options([]));
        $this->assertNotSame($widget, $widget->encodeLabels(true));
        $this->assertNotSame($widget, $widget->homeLink(true));
        $this->assertNotSame($widget, $widget->homeUrlLink([]));
        $this->assertNotSame($widget, $widget->links(['label' => 'value']));
        $this->assertNotSame($widget, $widget->itemTemplate(''));
        $this->assertNotSame($widget, $widget->activeItemTemplate(''));
    }
}
