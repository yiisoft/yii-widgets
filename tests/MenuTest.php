<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\Menu;

/**
 * MenuTest.
 */
final class MenuTest extends TestCase
{
    public function testEncodeLabelTrue(): void
    {
        $html = Menu::widget()
            ->encodeLabels(true)
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
            ->encodeLabels(false)
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

    /**
     * @see https://github.com/yiisoft/yii2/issues/8064
     */
    public function testTagOption(): void
    {
        $html = Menu::widget()
            ->encodeLabels(true)
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
            ->encodeLabels(true)
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
                    'active' => function ($item, $hasActiveChild, $isItemActive, $widget) {
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
            ->encodeLabels(true)
            ->activeCssClass('item-active')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'active' => true,
                    'options' => [
                        'class' => [
                            'someclass',
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
            ])
            ->render();

        $expected = <<<'HTML'
<ul><li class="someclass item-active"><a href="#">item1</a></li>
<li class="another-class other--class two classes"><a href="#">item2</a></li>
<li><a href="#">item3</a></li>
<li class="some-other-class foo_bar_baz_class"><a href="#">item4</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemClassAsString(): void
    {
        $html = Menu::widget()
            ->encodeLabels(true)
            ->activeCssClass('item-active')
            ->items([
                [
                    'label' => 'item1',
                    'url' => '#',
                    'options' => [
                        'class' => 'someclass',
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
<ul><li class="someclass"><a href="#">item1</a></li>
<li><a href="#">item2</a></li>
<li class="some classes"><a href="#">item3</a></li>
<li class="another-class other--class two classes item-active"><a href="#">item4</a></li></ul>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
