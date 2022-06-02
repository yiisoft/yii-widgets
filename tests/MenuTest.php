<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Widget\Widget;
use Yiisoft\Yii\Widgets\Menu;

/**
 * MenuTest.
 */
final class MenuTest extends TestCase
{
    public function testEncodeLabelTrue(): void
    {
        $html = Menu::widget()
            ->items([
                [
                    'encode' => false,
                    'label' => '<span class="glyphicon glyphicon-user"></span> Users',
                    'url' => '#',
                ],
                [
                    'encode' => true,
                    'label' => 'Authors & Publications',
                    'url' => '#',
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li><a href="#"><span class="glyphicon glyphicon-user"></span> Users</a></li>
<li><a href="#">Authors &amp; Publications</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabelFalse(): void
    {
        $html = Menu::widget()
            ->withoutEncodeLabels()
            ->items([
                [
                    'label' => '<span class="glyphicon glyphicon-user"></span> Users',
                    'url' => '#',
                ],
                [
                    'encode' => true,
                    'label' => 'Authors & Publications',
                    'url' => '#',
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li><a href="#"><span class="glyphicon glyphicon-user"></span> Users</a></li>
<li><a href="#">Authors &amp; Publications</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2/issues/8064
     */
    public function testTagOption(): void
    {
        $html = Menu::widget()
            ->options([
                'tag' => false,
            ])
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'options' => ['tag' => 'div'],
                ],
                [
                    'label' => 'item2',
                    'url' => '#',
                    'options' => ['tag' => false],
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<div><a href="#">item1</a></div>
<a href="#">item2</a>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);

        $html = Menu::widget()
            ->options([
                'tag' => false,
            ])
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                ],
                [
                    'label' => 'item2',
                    'url' => '#',
                ],
            ])
            ->itemOptions(['tag' => false])
            ->render();

        $expected = <<<'HTML'
<a href="#">item1</a>
<a href="#">item2</a>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemTemplate(): void
    {
        $html = Menu::widget()
            ->labelTemplate('')
            ->linkTemplate('')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'template' => 'label: {label}; url: {url}',
                ],
                [
                    'label' => 'item2',
                    'template' => 'label: {label}',
                ],
                [
                    'label' => 'item3 (no template)',
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li>label: item1; url: #</li>
<li>label: item2</li>
<li></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActiveItemClosure(): void
    {
        $html = Menu::widget()
            ->linkTemplate('')
            ->labelTemplate('')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'template' => 'label: {label}; url: {url}',
                    'active' => static function (
                        array $item,
                        bool $hasActiveChild,
                        bool $isItemActive,
                        Widget $widget
                    ): bool {
                        return isset($item, $hasActiveChild, $isItemActive, $widget);
                    },
                ],
                [
                    'label' => 'item2',
                    'template' => 'label: {label}',
                    'active' => false,
                ],
                [
                    'label' => 'item3 (no template)',
                    'active' => 'somestring',
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li class="active">label: item1; url: #</li>
<li>label: item2</li>
<li class="active"></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemClassAsArray(): void
    {
        $html = Menu::widget()
            ->activeCssClass('item-active')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'active' => true,
                    'options' => [
                        'class' => [
                            'some-class',
                        ],
                    ],
                ],
                [
                    'label' => 'item2',
                    'url' => '#',
                    'options' => [
                        'class' => [
                            'another-class',
                            'other--class',
                            'two classes',
                        ],
                    ],
                ],
                [
                    'label' => 'item3',
                    'url' => '#',
                ],
                [
                    'label' => 'item4',
                    'url' => '#',
                    'options' => [
                        'class' => [
                            'some-other-class',
                            'foo_bar_baz_class',
                        ],
                    ],
                ],
                [
                    'label' => 'item5',
                    'url' => '#',
                    'visible' => false,
                    'options' => [
                        'class' => [
                            'some-other-class',
                            'foo_bar_baz_class',
                        ],
                    ],
                ],
                [
                    'items' => [
                        ['label' => 'subItem1'],
                        ['label' => 'subItem2'],
                    ],
                ],
                [
                    'url' => '#',
                    'items' => [
                        ['label' => 'subItem1'],
                        ['label' => 'subItem2'],
                    ],
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li class="some-class item-active"><a href="#">item1</a></li>
<li class="another-class other--class two classes"><a href="#">item2</a></li>
<li><a href="#">item3</a></li>
<li class="some-other-class foo_bar_baz_class"><a href="#">item4</a></li>
<li>
<ul>
<li>subItem1</li>
<li>subItem2</li>
</ul>
</li>
<li><a href="#"></a>
<ul>
<li>subItem1</li>
<li>subItem2</li>
</ul>
</li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemClassAsString(): void
    {
        $html = Menu::widget()
            ->activeCssClass('item-active')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'options' => [
                        'class' => 'some-class',
                    ],
                ],
                [
                    'label' => 'item2',
                    'url' => '#',
                ],
                [
                    'label' => 'item3',
                    'url' => '#',
                    'options' => [
                        'class' => 'some classes',
                    ],
                ],
                [
                    'label' => 'item4',
                    'url' => '#',
                    'active' => true,
                    'options' => [
                        'class' => 'another-class other--class two classes',
                    ],
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li class="some-class"><a href="#">item1</a></li>
<li><a href="#">item2</a></li>
<li class="some classes"><a href="#">item3</a></li>
<li class="another-class other--class two classes item-active"><a href="#">item4</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFirstAndLastItemCssClass(): void
    {
        $html = Menu::widget()
            ->firstItemCssClass('first-class')
            ->lastItemCssClass('last-class')
            ->items([
                6 => [
                    'label' => 'item1',
                    'url' => '#',
                    'options' => [
                        'class' => 'some-class',
                    ],
                ],
                3 => [
                    'label' => 'item2',
                    'url' => '#',
                    'options' => [
                        'class' => 'some-class',
                    ],
                ],
                1 => [
                    'label' => 'item3',
                    'url' => '#',
                    'options' => [
                        'class' => 'some-class',
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
<ul><li class="some-class first-class"><a href="#">item1</a></li>
<li class="some-class"><a href="#">item2</a></li>
<li class="some-class last-class"><a href="#">item3</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCurrentPath(): void
    {
        $html = Menu::widget()
            ->currentPath('/path')
            ->items([
                [
                    'label' => 'item',
                    'url' => '/path',
                ],
            ])
            ->render();

        $expected = '<ul><li class="active"><a href="/path">item</a></li></ul>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHomeCurrentPath(): void
    {
        $html = Menu::widget()
            ->currentPath('/')
            ->items([
                [
                    'label' => 'item',
                    'url' => '/',
                ],
            ])
            ->render();

        $expected = '<ul><li><a href="/">item</a></li></ul>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDeactivateItems(): void
    {
        $html = Menu::widget()
            ->currentPath('/path')
            ->deactivateItems()
            ->items([
                [
                    'label' => 'item',
                    'url' => '/path',
                ],
            ])
            ->render();

        $expected = '<ul><li><a href="/path">item</a></li></ul>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testActivateParents(): void
    {
        $html = Menu::widget()
            ->activateParents()
            ->items([
                [
                    'label' => 'item1',
                    'active' => true,
                    'items' => [
                        ['label' => 'subItem1'],
                        ['label' => 'subItem2'],
                    ],
                ],
                [
                    'label' => 'item2',
                    'active' => false,
                    'items' => [
                        ['label' => 'subItem1', 'active' => true],
                        ['label' => 'subItem2'],
                    ],
                ],
                [
                    'label' => 'item3',
                    'items' => [
                        ['label' => 'subItem1'],
                        ['label' => 'subItem2', 'active' => true],
                    ],
                ],
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li class="active">item1
<ul>
<li>subItem1</li>
<li>subItem2</li>
</ul>
</li>
<li>item2
<ul>
<li class="active">subItem1</li>
<li>subItem2</li>
</ul>
</li>
<li class="active">item3
<ul>
<li>subItem1</li>
<li class="active">subItem2</li>
</ul>
</li></ul>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testShowEmptyItems(): void
    {
        $html = Menu::widget()
            ->showEmptyItems()
            ->items([
                [
                    'label' => 'item',
                    'options' => [
                        'class' => 'some-class',
                    ],
                    'items' => [
                        ['label' => 'subItem1', 'visible' => false],
                        ['label' => 'subItem2', 'visible' => false],
                    ],
                ],
            ])
            ->render();

        $expected = '<ul><li class="some-class">item</li></ul>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEmptyItems(): void
    {
        $this->assertEqualsWithoutLE('', Menu::widget()
            ->items([])
            ->render());
    }

    public function testShowEmptyChildItems(): void
    {
        $this->assertEqualsWithoutLE('', Menu::widget()
            ->items([
                [
                    'label' => 'item1',
                    'options' => [
                        'class' => 'some-class',
                    ],
                    'items' => [],
                ],
                [
                    'label' => 'item2',
                    'options' => [
                        'class' => 'some-class',
                    ],
                    'items' => [],
                ],
            ])
            ->render());
    }

    public function testImmutability(): void
    {
        $widget = Menu::widget();

        $this->assertNotSame($widget, $widget->deactivateItems());
        $this->assertNotSame($widget, $widget->activateParents());
        $this->assertNotSame($widget, $widget->activeCssClass(''));
        $this->assertNotSame($widget, $widget->currentPath(''));
        $this->assertNotSame($widget, $widget->withoutEncodeLabels());
        $this->assertNotSame($widget, $widget->firstItemCssClass(''));
        $this->assertNotSame($widget, $widget->showEmptyItems());
        $this->assertNotSame($widget, $widget->items([]));
        $this->assertNotSame($widget, $widget->itemOptions([]));
        $this->assertNotSame($widget, $widget->labelTemplate(''));
        $this->assertNotSame($widget, $widget->lastItemCssClass(''));
        $this->assertNotSame($widget, $widget->linkTemplate(''));
        $this->assertNotSame($widget, $widget->options([]));
    }
}
