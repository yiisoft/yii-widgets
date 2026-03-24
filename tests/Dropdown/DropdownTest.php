<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class DropdownTest extends TestCase
{
    use TestTrait;

    private array $items = [
        ['label' => 'Action', 'link' => '#', 'active' => true],
        ['label' => 'Another action', 'link' => '#'],
        ['label' => 'Something else here', 'link' => '#'],
        '-',
        ['label' => 'Separated link', 'link' => '#', 'disabled' => true],
    ];

    public function testActiveClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a aria-current="true" class="test-active-class" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->activeClass('test-active-class')->items($this->items)->render(),
        );
    }

    public function testContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <li><a aria-current="true" class="active" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->containerAttributes(['class' => 'dropdown'])->items($this->items)->render(),
        );
    }

    public function testContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <li><a aria-current="true" class="active" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->containerClass('dropdown')->items($this->items)->render(),
        );
    }

    public function testContainerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <article>
            <li><a aria-current="true" class="active" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </article>
            HTML,
            Dropdown::widget()->containerTag('article')->items($this->items)->render(),
        );
    }

    public function testDisabledClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a aria-current="true" class="active" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="test-disabled-class" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->disabledClass('test-disabled-class')->items($this->items)->render(),
        );
    }

    public function testDividerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a aria-current="true" class="active" href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><span class="dropdown-divider"></span></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->dividerTag('span')->items($this->items)->render(),
        );
    }

    public function testItemContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <a aria-current="true" class="active" href="#">Action</a>
            <a href="#">Another action</a>
            <a href="#">Something else here</a>
            <li><hr class="dropdown-divider"></li>
            <a class="disabled" href="#">Separated link</a>
            </div>
            HTML,
            Dropdown::widget()->itemContainer(false)->items($this->items)->render(),
        );
    }

    public function testItemContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a aria-current="true" class="active" href="#">Action</a></li>
            <li class="test-class"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->itemContainerAttributes(['class' => 'test-class'])->items($this->items)->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a aria-current="true" class="active" href="#">Action</a></li>
            <li class="test-class-2"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class-5"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->itemContainerAttributes(['class' => 'test-class'])
                ->items(
                    [
                        ['label' => 'Action', 'link' => '#', 'active' => true],
                        [
                            'label' => 'Another action',
                            'link' => '#',
                            'itemContainerAttributes' => ['class' => 'test-class-2'],
                        ],
                        ['label' => 'Something else here', 'link' => '#'],
                        '-',
                        [
                            'label' => 'Separated link',
                            'link' => '#', 'disabled' => true,
                            'itemContainerAttributes' => ['class' => 'test-class-5'],
                        ],
                    ],
                )
                ->render(),
        );
    }

    public function testItemContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a aria-current="true" class="active" href="#">Action</a></li>
            <li class="test-class"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->itemContainerClass('test-class')->items($this->items)->render(),
        );
    }

    public function testItemsEncodeDefault(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black &amp; White</a></li>
            </div>
            HTML,
            Dropdown::widget()->items([['label' => 'Black & White']])->render(),
        );
    }

    public function testItemsEncodeWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black & White</a></li>
            </div>
            HTML,
            Dropdown::widget()->items([['label' => 'Black & White', 'encode' => false]])->render(),
        );
    }

    public function testItemsIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i>🏠</i></span>Home</a></li>
            <li><a href="#"><span><i>📧</i></span>Contact</a></li>
            <li><a href="#"><span><i>🔑</i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'icon' => '🏠'],
                    ['label' => 'Contact', 'link' => '#', 'icon' => '📧'],
                    ['label' => 'Login', 'link' => '#', 'icon' => '🔑'],
                ])
                ->render(),
        );
    }

    public function testItemsIconAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'iconAttributes' => ['class' => 'bi bi-house']],
                        ['label' => 'Contact', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-envelope']],
                        ['label' => 'Login', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-lock']],
                    ],
                )->render(),
        );
    }

    public function testItemsIconClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                    ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                    ['label' => 'Login', 'link' => '#', 'iconClass' => 'bi bi-lock'],
                ])
                ->render(),
        );
    }

    public function testItemsIconContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span class="test-class-1"><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                    ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                    [
                        'label' => 'Login',
                        'link' => '#',
                        'iconClass' => 'bi bi-lock',
                        'iconContainerAttributes' => ['class' => 'test-class-1'],
                    ],
                ])
                ->render(),
        );
    }

    public function testItemsIconWithEmptyStringLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i>🏠</i></span></a></li>
            <li><a href="#"><span><i>📧</i></span></a></li>
            <li><a href="#"><span><i>🔑</i></span></a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => '', 'link' => '/active', 'icon' => '🏠'],
                    ['label' => '', 'link' => '#', 'icon' => '📧'],
                    ['label' => '', 'link' => '#', 'icon' => '🔑'],
                ])
                ->render(),
        );
    }

    public function testItemsLinkAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a class="text-danger" href="/">Black &amp; White</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([['label' => 'Black & White', 'linkAttributes' => ['class' => 'text-danger']]])
                ->render(),
        );
    }

    public function testItemsVisible(): void
    {
        $this->assertEmpty(
            Dropdown::widget()->items([['label' => 'Black & White', 'visible' => false]])->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black &amp; White</a></li>
            <li><a href="/">Green &amp; Blue</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Black & White'],
                        ['label' => 'Red & Yellow', 'visible' => false],
                        ['label' => 'Green & Blue', 'visible' => true],
                    ],
                )
                ->render(),
        );
    }

    public function testItemEnclose(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            raw content
            <li><a href="#">Action</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'raw content', 'enclose' => false],
                        ['label' => 'Action', 'link' => '#'],
                    ],
                )
                ->render(),
        );
    }

    public function testHeaderWithHtmlLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><span><b>Bold</b></span></li>
            <li><a href="#">Action</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => '<b>Bold</b>', 'link' => '', 'encode' => false],
                        ['label' => 'Action', 'link' => '#'],
                    ],
                )
                ->render(),
        );
    }

    public function testNonSplitWithDropstart(): void
    {
        $html = Dropdown::widget()
            ->containerClass('btn-group dropstart')
            ->toggleClass('btn btn-secondary dropdown-toggle')
            ->toggleAttributes(['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown'])
            ->items(
                [
                    [
                        'label' => 'Dropstart',
                        'link' => '#',
                        'items' => [
                            ['label' => 'Action', 'link' => '#'],
                        ],
                    ],
                ],
            )
            ->render();

        $this->assertSame(1, substr_count($html, '<button'));
    }

    public function testItemHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><span class="custom-header">Section</span></li>
            <li><a href="#">Action</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Section', 'link' => '', 'headerAttributes' => ['class' => 'custom-header']],
                        ['label' => 'Action', 'link' => '#'],
                    ],
                )
                ->render(),
        );
    }

    public function testDividerAsArrayItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="#">Action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="#">Other</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Action', 'link' => '#'],
                        ['label' => '-'],
                        ['label' => 'Other', 'link' => '#'],
                    ],
                )
                ->render(),
        );
    }

    public function testItemToggleAttributes(): void
    {
        $html = Dropdown::widget()
            ->containerClass('btn-group')
            ->toggleType('split')
            ->splitButtonClass('btn')
            ->splitButtonSpanClass('sr-only')
            ->toggleClass('btn dropdown-toggle')
            ->toggleAttributes(['data-bs-toggle' => 'dropdown'])
            ->items(
                [
                    [
                        'label' => 'Parent',
                        'link' => '#',
                        'toggleAttributes' => ['data-custom' => 'value'],
                        'items' => [
                            ['label' => 'Child', 'link' => '#'],
                        ],
                    ],
                ],
            )
            ->render();

        $this->assertStringContainsString('data-custom="value"', $html);
    }

    public function testSortItems(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">Alpha</a></li>
            <li><a href="/b">Beta</a></li>
            <li><a href="/g">Gamma</a></li>
            </div>
            HTML,
            Dropdown::widget()
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
