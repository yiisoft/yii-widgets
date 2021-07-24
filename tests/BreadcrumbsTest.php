<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Widgets\Breadcrumbs;

final class BreadcrumbsTest extends TestCase
{
    public function testItems(): void
    {
        $html = Breadcrumbs::widget()
            ->items([
                'label' => 'My Home Page', 'url' => 'https://my.example.com/yii/link/page',
            ])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li><a href=\"/\">Home</a></li>\n" .
            "<li class=\"active\">My Home Page</li>\n" .
            "<li class=\"active\">https://my.example.com/yii/link/page</li>\n" .
            '</ul>'
        ;

        $this->assertEquals($expectedHtml, $html);
    }

    public function testItemsWithTemplate(): void
    {
        $html = Breadcrumbs::widget()
            ->items([
                ['label' => 'Link', 'url' => 'https://my.example.com/yii/link/page'],
                ['label' => 'Text', 'template' => "<span>{link}</span>\n"],
            ])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li><a href=\"/\">Home</a></li>\n" .
            "<li><a href=\"https://my.example.com/yii/link/page\">Link</a></li>\n" .
            "<span>Text</span>\n" .
            '</ul>'
        ;

        $this->assertEquals($expectedHtml, $html);
    }

    public function testEmptyLinks(): void
    {
        $html = Breadcrumbs::widget()->render();

        $this->assertEmpty($html);
    }

    public function testWithoutHomeItem(): void
    {
        $html = Breadcrumbs::widget()
            ->homeItem(null)
            ->items([
                'label' => 'My Home Page',
                'url' => 'http://my.example.com/yii2/link/page',
            ])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li class=\"active\">My Home Page</li>\n" .
            "<li class=\"active\">http://my.example.com/yii2/link/page</li>\n" .
            '</ul>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testHomeItem(): void
    {
        $html = Breadcrumbs::widget()
            ->homeItem(['label' => 'home-link'])
            ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
            ->render();

        $expectedHtml = "<ul class=\"breadcrumb\"><li>home-link</li>\n" .
            "<li class=\"active\">My Home Page</li>\n" .
            "<li class=\"active\">http://my.example.com/yii2/link/page</li>\n" .
            '</ul>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testRenderItemException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Breadcrumbs::widget()
            ->homeItem(null)
            ->items([
                ['url' => 'http://my.example.com/yii2/link/page'],
            ])
            ->render();
    }

    public function testRenderItemLabelOnlyEncodeLabelFalse(): void
    {
        $html = Breadcrumbs::widget()
            ->activeItemTemplate("<li>{link}</li>\n")
            ->withoutEncodeLabels()
            ->items(['label' => 'My-<br>Test-Label'])
            ->homeItem(null)
            ->options([])
            ->tag('')
            ->render();

        $this->assertEquals("<li>My-<br>Test-Label</li>\n", $html);
    }

    public function testRenderItemLabelOnlyEncodeLabelTrue(): void
    {
        $html = Breadcrumbs::widget()
            ->activeItemTemplate("<li>{link}</li>\n")
            ->items(['label' => 'My-<br>Test-Label'])
            ->homeItem(null)
            ->options([])
            ->tag('')
            ->render();

        $this->assertEquals("<li>My-&lt;br&gt;Test-Label</li>\n", $html);
    }

    public function testOptions(): void
    {
        $html = Breadcrumbs::widget()
            ->homeItem(null)
            ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
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
            ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
            ->options(['class' => 'breadcrumb'])
            ->tag('div')
            ->render();

        $expectedHtml = "<div class=\"breadcrumb\"><a href=\"/\">Home</a>\n" .
            "My Home Page\n" .
            "http://my.example.com/yii2/link/page\n" .
            '</div>';

        $this->assertEquals($expectedHtml, $html);
    }

    public function testHomeItemThrowExceptionForEmptyArray(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The home item cannot be an empty array. To disable rendering of the home item, specify null.',
        );
        Breadcrumbs::widget()->homeItem([]);
    }

    public function testImmutability(): void
    {
        $widget = Breadcrumbs::widget();

        $this->assertNotSame($widget, $widget->tag('ul'));
        $this->assertNotSame($widget, $widget->options([]));
        $this->assertNotSame($widget, $widget->withoutEncodeLabels());
        $this->assertNotSame($widget, $widget->homeItem(null));
        $this->assertNotSame($widget, $widget->items(['label' => 'value']));
        $this->assertNotSame($widget, $widget->itemTemplate(''));
        $this->assertNotSame($widget, $widget->activeItemTemplate(''));
    }
}
