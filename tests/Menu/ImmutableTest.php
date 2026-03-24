<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ImmutableTest extends TestCase
{
    use TestTrait;

    public function testImmutable(): void
    {
        $menu = Menu::widget();
        $this->assertNotSame($menu, $menu->activateItems(false));
        $this->assertNotSame($menu, $menu->afterAttributes([]));
        $this->assertNotSame($menu, $menu->afterClass(''));
        $this->assertNotSame($menu, $menu->afterContent(''));
        $this->assertNotSame($menu, $menu->afterTag(''));
        $this->assertNotSame($menu, $menu->activeClass(''));
        $this->assertNotSame($menu, $menu->addItem([]));
        $this->assertNotSame($menu, $menu->attributes([]));
        $this->assertNotSame($menu, $menu->beforeAttributes([]));
        $this->assertNotSame($menu, $menu->beforeClass(''));
        $this->assertNotSame($menu, $menu->beforeContent(''));
        $this->assertNotSame($menu, $menu->beforeTag(''));
        $this->assertNotSame($menu, $menu->class(''));
        $this->assertNotSame($menu, $menu->container(false));
        $this->assertNotSame($menu, $menu->currentPath(''));
        $this->assertNotSame($menu, $menu->disabledClass(''));
        $this->assertNotSame($menu, $menu->dropdownContainerClass(''));
        $this->assertNotSame($menu, $menu->dropdownContainerTag('div'));
        $this->assertNotSame($menu, $menu->dropdownDefinitions([]));
        $this->assertNotSame($menu, $menu->firstItemClass(''));
        $this->assertNotSame($menu, $menu->iconContainerAttributes([]));
        $this->assertNotSame($menu, $menu->id('test'));
        $this->assertNotSame($menu, $menu->items([]));
        $this->assertNotSame($menu, $menu->itemsContainer(false));
        $this->assertNotSame($menu, $menu->itemsContainerAttributes([]));
        $this->assertNotSame($menu, $menu->itemsContainerClass(''));
        $this->assertNotSame($menu, $menu->itemsTag(''));
        $this->assertNotSame($menu, $menu->lastItemClass(''));
        $this->assertNotSame($menu, $menu->linkAttributes([]));
        $this->assertNotSame($menu, $menu->linkClass(''));
        $this->assertNotSame($menu, $menu->linkTag(''));
        $this->assertNotSame($menu, $menu->prependItem([]));
        $this->assertNotSame($menu, $menu->tagName(''));
        $this->assertNotSame($menu, $menu->template(''));
    }
}
