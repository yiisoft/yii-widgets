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
}
