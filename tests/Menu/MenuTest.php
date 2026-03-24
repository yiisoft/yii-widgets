<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;
use InvalidArgumentException;

final class MenuTest extends TestCase
{
    use TestTrait;

    private array $items = [
        ['label' => 'item', 'link' => '/path'],
    ];
    private array $itemsWithOptions = [
        ['label' => 'Active', 'link' => '/active'],
        ['label' => 'Much longer nav link', 'link' => '#'],
        ['label' => 'Link', 'link' => '#'],
        ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
    ];

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="test-class">
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()->attributes(['class' => 'test-class'])->items($this->items)->render(),
        );
    }

    public function testActiveItemsWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()->activateItems(false)->currentPath('/path')->items($this->items)->render(),
        );
    }

    public function testAfter(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a aria-current="page" class="active" href="/path">item</a></li>
            </ul>
            <a class="navbar-brand">Hidden brand</a>
            HTML,
            Menu::widget()
                ->afterClass('navbar-brand')
                ->afterContent('Hidden brand')
                ->afterTag('a')
                ->currentPath('/path')
                ->items($this->items)
                ->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a aria-current="page" class="active" href="/path">item</a></li>
            </ul>
            <span role="search" class="d-flex"><input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button></span>
            HTML,
            Menu::widget()
                ->afterAttributes(['role' => 'search'])
                ->afterClass('d-flex')
                ->afterContent(
                    <<<HTML
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    HTML,
                )
                ->currentPath('/path')
                ->items($this->items)
                ->render(),
        );
    }

    public function testActiveWithNotBool(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()
               ->currentPath('/path')
               ->items([['label' => 'item', 'link' => '/path', 'active' => 'not-bool']])
               ->render(),
        );
    }

    public function testBefore(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="navbar-brand">Hidden brand</a>
            <ul>
            <li><a aria-current="page" class="active" href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->beforeClass('navbar-brand')
                ->beforeContent('Hidden brand')
                ->beforeTag('a')
                ->currentPath('/path')
                ->items($this->items)
                ->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <span role="search" class="d-flex"><input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button></span>
            <ul>
            <li><a aria-current="page" class="active" href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->beforeAttributes(['role' => 'search'])
                ->beforeClass('d-flex')
                ->beforeContent(
                    <<<HTML
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    HTML,
                )
                ->currentPath('/path')
                ->items($this->items)
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="test-class">
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()->class('test-class')->items($this->items)->render(),
        );
    }

    public function testContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li><a href="/active">Active</a></li>
            <li><a href="#">Much longer nav link</a></li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled" href="#">Disabled</a></li>
            HTML,
            Menu::widget()->container(false)->items($this->itemsWithOptions)->render(),
        );
    }

    public function testDisabledClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/active">Active</a></li>
            <li><a href="#">Much longer nav link</a></li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled-class" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->disabledClass('disabled-class')->items($this->itemsWithOptions)->render(),
        );
    }

    public function testDropdown(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a aria-current="page" class="active" href="/active">Active</a></li>
            <li>
            <a aria-expanded="false" data-bs-toggle="dropdown" role="button" href="#">Dropdown</a>
            <ul>
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="#">Separated link</a></li>
            </ul>
            </li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->currentPath('/active')
                ->items(
                    [
                        ['label' => 'Active', 'link' => '/active'],
                        [
                            'label' => 'Dropdown',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                        ['label' => 'Link', 'link' => '#'],
                        ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
                    ],
                )
                ->render(),
        );
    }

    public function testDropdownContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a aria-current="page" class="active" href="/active">Active</a></li>
            <li class="nav-item dropdown">
            <a aria-expanded="false" data-bs-toggle="dropdown" role="button" href="#">Dropdown</a>
            <ul>
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="#">Separated link</a></li>
            </ul>
            </li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->currentPath('/active')
                ->dropdownContainerClass('nav-item dropdown')
                ->items(
                    [
                        ['label' => 'Active', 'link' => '/active'],
                        [
                            'label' => 'Dropdown',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                        ['label' => 'Link', 'link' => '#'],
                        ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
                    ],
                )
                ->render(),
        );
    }

    public function testDropdownDefinitions(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a aria-current="page" class="active" href="/active">Active</a></li>
            <li>
            <a aria-expanded="false" data-bs-toggle="dropdown" role="button" class="dropdown-toggle" href="#">Dropdown</a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->currentPath('/active')
                ->dropdownDefinitions(
                    [
                        'container()' => [false],
                        'dividerClass()' => ['dropdown-divider'],
                        'headerClass()' => ['dropdown-header'],
                        'itemClass()' => ['dropdown-item'],
                        'itemsContainerClass()' => ['dropdown-menu'],
                        'toggleAttributes()' => [
                            [
                                'aria-expanded' => 'false',
                                'data-bs-toggle' => 'dropdown',
                                'role' => 'button',
                            ],
                        ],
                        'toggleClass()' => ['dropdown-toggle'],
                        'toggleType()' => ['link'],
                    ],
                )
                ->items(
                    [
                        ['label' => 'Active', 'link' => '/active'],
                        [
                            'label' => 'Dropdown',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                        ['label' => 'Link', 'link' => '#'],
                        ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
                    ],
                )
                ->render(),
        );
    }

    public function testFirstItemCssClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li class="first-item-class"><a href="/active">Active</a></li>
            <li><a href="#">Much longer nav link</a></li>
            <li><a href="#">Link</a></li>
            <li><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->firstItemClass('first-item-class')->items($this->itemsWithOptions)->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul id="my-menu">
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()->id('my-menu')->items($this->items)->render(),
        );
    }

    public function testIdEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Menu::widget()->id('');
    }

    public function testItemsClassAsArray(): void
    {
        $items = [
            [
                'label' => 'item1',
                'link' => '#',
                'active' => true,
                'itemsContainerAttributes' => ['class' => ['some-class']],
            ],
            [
                'label' => 'item2',
                'link' => '#',
                'itemsContainerAttributes' => ['class' => ['another-class', 'other--class', 'two classes']],
            ],
            [
                'label' => 'item3',
                'link' => '#',
            ],
            [
                'label' => 'item4',
                'link' => '#',
                'itemsContainerAttributes' => ['class' => ['some-other-class', 'foo_bar_baz_class']],
            ],
            [
                'label' => 'item5',
                'link' => '#',
                'attributes' => ['class' => ['some-other-class', 'foo_bar_baz_class']],
                'visible' => false,
            ],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li class="some-class"><a aria-current="page" class="item-active" href="#">item1</a></li>
            <li class="another-class other--class two classes"><a href="#">item2</a></li>
            <li><a href="#">item3</a></li>
            <li class="some-other-class foo_bar_baz_class"><a href="#">item4</a></li>
            </ul>
            HTML,
            Menu::widget()->activeClass('item-active')->items($items)->render(),
        );
    }

    public function testItemsContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li class="nav-item"><a href="/active">Active</a></li>
            <li class="nav-item"><a href="#">Much longer nav link</a></li>
            <li class="nav-item"><a href="#">Link</a></li>
            <li class="nav-item"><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->itemsContainerAttributes(['class' => 'nav-item'])->items($this->itemsWithOptions)->render(),
        );
    }

    public function testItemsContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li class="nav-item"><a href="/active">Active</a></li>
            <li class="nav-item"><a href="#">Much longer nav link</a></li>
            <li class="nav-item"><a href="#">Link</a></li>
            <li class="nav-item"><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->itemsContainerClass('nav-item')->items($this->itemsWithOptions)->render(),
        );
    }

    public function testItemsContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <a href="/active">Active</a>
            <a href="#">Much longer nav link</a>
            <a href="#">Link</a>
            <a class="disabled" href="#">Disabled</a>
            </ul>
            HTML,
            Menu::widget()->itemsContainer(false)->items($this->itemsWithOptions)->render(),
        );
    }

    public function testItemsEncodeDefault(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li>Black &amp; White</li>
            </ul>
            HTML,
            Menu::widget()->items([['label' => 'Black & White']])->render(),
        );
    }

    public function testItemsEncodeWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li>Black & White</li>
            </ul>
            HTML,
            Menu::widget()->items([['label' => 'Black & White', 'encode' => false]])->render(),
        );
    }

    public function testItemsIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="me-2" href="/active"><span class="me-2"><i>🏠</i></span>Home</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i>📧</i></span>Contact</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i>🔑</i></span>Login</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->iconContainerAttributes(['class' => 'me-2'])
                ->linkAttributes(['class' => 'me-2'])
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'icon' => '🏠'],
                        ['label' => 'Contact', 'link' => '#', 'icon' => '📧'],
                        ['label' => 'Login', 'link' => '#', 'icon' => '🔑'],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsIconAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="me-2" href="/active"><span class="me-2"><i class="bi bi-house"></i></span>Home</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i class="bi bi-lock"></i></span>Login</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->iconContainerAttributes(['class' => 'me-2'])
                ->linkAttributes(['class' => 'me-2'])
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'iconAttributes' => ['class' => 'bi bi-house']],
                        ['label' => 'Contact', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-envelope']],
                        ['label' => 'Login', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-lock']],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsIconClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="me-2" href="/active"><span class="me-2"><i class="bi bi-house"></i></span>Home</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i class="bi bi-lock"></i></span>Login</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->iconContainerAttributes(['class' => 'me-2'])
                ->linkAttributes(['class' => 'me-2'])
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                        ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                        ['label' => 'Login', 'link' => '#', 'iconClass' => 'bi bi-lock'],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsIconContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="me-2" href="/active"><span class="me-2"><i class="bi bi-house"></i></span>Home</a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a class="me-2" href="#"><span class="me-3"><i class="bi bi-lock"></i></span>Login</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->iconContainerAttributes(['class' => 'me-2'])
                ->linkAttributes(['class' => 'me-2'])
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                        ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                        [
                            'label' => 'Login',
                            'link' => '#',
                            'iconClass' => 'bi bi-lock',
                            'iconContainerAttributes' => ['class' => 'me-3'],
                        ],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsIconWithEmptyStringLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="me-2" href="/active"><span class="me-2"><i>🏠</i></span></a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i>📧</i></span></a></li>
            <li><a class="me-2" href="#"><span class="me-2"><i>🔑</i></span></a></li>
            </ul>
            HTML,
            Menu::widget()
                ->iconContainerAttributes(['class' => 'me-2'])
                ->linkAttributes(['class' => 'me-2'])
                ->items(
                    [
                        ['label' => '', 'link' => '/active', 'icon' => '🏠'],
                        ['label' => '', 'link' => '#', 'icon' => '📧'],
                        ['label' => '', 'link' => '#', 'icon' => '🔑'],
                    ],
                )
                ->render(),
        );
    }

    public function testLastItemCssClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/active">Active</a></li>
            <li><a href="#">Much longer nav link</a></li>
            <li><a href="#">Link</a></li>
            <li class="last-item-class"><a class="disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->lastItemClass('last-item-class')->items($this->itemsWithOptions)->render(),
        );
    }

    public function testLinkClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="test-class" href="/active">Active</a></li>
            <li><a class="test-class" href="#">Much longer nav link</a></li>
            <li><a class="test-class" href="#">Link</a></li>
            <li><a class="test-class disabled" href="#">Disabled</a></li>
            </ul>
            HTML,
            Menu::widget()->linkClass('test-class')->items($this->itemsWithOptions)->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertEmpty(Menu::widget()->render());
    }

    public function testTemplate(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <div class="test-class"><li><a href="/active">Active</a></li></div>
            <div class="test-class"><li><a href="#">Much longer nav link</a></li></div>
            <div class="test-class"><li><a href="#">Link</a></li></div>
            <div class="test-class"><li><a class="disabled" href="#">Disabled</a></li></div>
            </ul>
            HTML,
            Menu::widget()->items($this->itemsWithOptions)->template('<div class="test-class">{items}</div>')->render(),
        );
    }

    public function testAfterContentWithStringable(): void
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Stringable content';
            }
        };

        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/path">item</a></li>
            </ul>
            <span>Stringable content</span>
            HTML,
            Menu::widget()
                ->afterContent($stringable)
                ->afterTag('span')
                ->items($this->items)
                ->render(),
        );
    }

    public function testBeforeContentWithStringable(): void
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Before text';
            }
        };

        Assert::equalsWithoutLE(
            <<<HTML
            <span>Before text</span>
            <ul>
            <li><a href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->beforeContent($stringable)
                ->beforeTag('span')
                ->items($this->items)
                ->render(),
        );
    }

    public function testContainerFalseWithBeforeAndAfter(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <span>Before</span>
            <li><a href="/path">item</a></li>
            <span>After</span>
            HTML,
            Menu::widget()
                ->beforeContent('Before')
                ->beforeTag('span')
                ->afterContent('After')
                ->afterTag('span')
                ->container(false)
                ->items($this->items)
                ->render(),
        );
    }

    public function testItemLinkAttributesOverrideWidgetLinkAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a class="item-class" href="/path">item</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->linkAttributes(['class' => 'widget-class'])
                ->items([
                    ['label' => 'item', 'link' => '/path', 'linkAttributes' => ['class' => 'item-class']],
                ])
                ->render(),
        );
    }

    public function testSortItems(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/a">Alpha</a></li>
            <li><a href="/b">Beta</a></li>
            <li><a href="/g">Gamma</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->items([
                    ['label' => 'Gamma', 'link' => '/g'],
                    ['label' => 'Alpha', 'link' => '/a'],
                    ['label' => 'Beta', 'link' => '/b'],
                ])
                ->sortItems(fn(array $a, array $b): int => strcmp((string) $a['label'], (string) $b['label']))
                ->render(),
        );
    }
}
