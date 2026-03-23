<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Helper\Normalizer;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class NormalizerTest extends TestCase
{
    public function testDropdownRemovesRawKeys(): void
    {
        $items = Normalizer::dropdown([
            [
                'label' => 'Item',
                'link' => '#',
                'encode' => false,
                'icon' => 'home',
                'iconAttributes' => ['class' => 'bi'],
                'iconClass' => 'bi-home',
                'iconContainerAttributes' => ['class' => 'icon'],
            ],
        ]);

        $this->assertArrayNotHasKey('encode', $items[0]);
        $this->assertArrayNotHasKey('icon', $items[0]);
        $this->assertArrayNotHasKey('iconAttributes', $items[0]);
        $this->assertArrayNotHasKey('iconClass', $items[0]);
        $this->assertArrayNotHasKey('iconContainerAttributes', $items[0]);
    }

    public function testMenuRemovesRawKeys(): void
    {
        $items = Normalizer::menu(
            [
                [
                    'label' => 'Item',
                    'link' => '#',
                    'encode' => false,
                    'icon' => 'home',
                    'iconAttributes' => ['class' => 'bi'],
                    'iconClass' => 'bi-home',
                    'iconContainerAttributes' => ['class' => 'icon'],
                ],
            ],
            '',
            false,
        );

        $this->assertArrayNotHasKey('encode', $items[0]);
        $this->assertArrayNotHasKey('icon', $items[0]);
        $this->assertArrayNotHasKey('iconAttributes', $items[0]);
        $this->assertArrayNotHasKey('iconClass', $items[0]);
        $this->assertArrayNotHasKey('iconContainerAttributes', $items[0]);
    }

    public function testRenderLabel(): void
    {
        $this->assertSame('test', Normalizer::renderLabel('test', '', [], '', []));
    }
}
