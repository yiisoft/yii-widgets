<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutable(): void
    {
        $dropdown = Dropdown::widget();
        $this->assertNotSame($dropdown, $dropdown->activeClass(''));
        $this->assertNotSame($dropdown, $dropdown->container(false));
        $this->assertNotSame($dropdown, $dropdown->containerAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->containerClass(''));
        $this->assertNotSame($dropdown, $dropdown->containerTag(''));
        $this->assertNotSame($dropdown, $dropdown->disabledClass(''));
        $this->assertNotSame($dropdown, $dropdown->dividerAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->dividerClass(''));
        $this->assertNotSame($dropdown, $dropdown->dividerTag(''));
        $this->assertNotSame($dropdown, $dropdown->headerClass(''));
        $this->assertNotSame($dropdown, $dropdown->headerTag(''));
        $this->assertNotSame($dropdown, $dropdown->id(''));
        $this->assertNotSame($dropdown, $dropdown->itemClass(''));
        $this->assertNotSame($dropdown, $dropdown->itemContainer(false));
        $this->assertNotSame($dropdown, $dropdown->itemContainerAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->itemContainerClass(''));
        $this->assertNotSame($dropdown, $dropdown->itemContainerTag(''));
        $this->assertNotSame($dropdown, $dropdown->itemTag(''));
        $this->assertNotSame($dropdown, $dropdown->items([]));
        $this->assertNotSame($dropdown, $dropdown->itemsContainerAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->itemsContainerClass(''));
        $this->assertNotSame($dropdown, $dropdown->itemsContainerTag(''));
        $this->assertNotSame($dropdown, $dropdown->splitButtonAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->splitButtonClass(''));
        $this->assertNotSame($dropdown, $dropdown->splitButtonSpanClass(''));
        $this->assertNotSame($dropdown, $dropdown->toggleAttributes([]));
        $this->assertNotSame($dropdown, $dropdown->toggleClass(''));
        $this->assertNotSame($dropdown, $dropdown->toggleType(''));
    }
}
