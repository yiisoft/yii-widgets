<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
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
            <li><a class="test-active-class" href="#" aria-current="true">Action</a></li>
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
            <li><a class="active" href="#" aria-current="true">Action</a></li>
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
            <li><a class="active" href="#" aria-current="true">Action</a></li>
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
            <li><a class="active" href="#" aria-current="true">Action</a></li>
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
            <li><a class="active" href="#" aria-current="true">Action</a></li>
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
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><span class="dropdown-divider"></span></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->dividerTag('span')->items($this->items)->render(),
        );
    }

    public function testIcons(): void
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

    public function testItemContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <a class="active" href="#" aria-current="true">Action</a>
            <a href="#">Another action</a>
            <a href="#">Something else here</a>
            <li><hr class="dropdown-divider"></li>
            <a class="disabled" href="#">Separated link</a>
            </div>
            HTML,
            Dropdown::widget()->itemContainer(false)->items($this->items)->render(),
        );
    }

    public function testItemContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a class="active" href="#" aria-current="true">Action</a></li>
            <li class="test-class"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->itemContainerClass('test-class')->items($this->items)->render(),
        );
    }
}
