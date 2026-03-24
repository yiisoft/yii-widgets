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
    public function testRenderLabel(): void
    {
        $this->assertSame('test', Normalizer::renderLabel('test', '', [], '', []));
    }

    public function testMenuData(): void
    {
        $result = Normalizer::menuData(
            [
                ['label' => 'Home', 'link' => '/'],
                ['label' => 'About', 'link' => '/about', 'disabled' => true],
            ],
            '/',
            true,
        );

        $this->assertSame('Home', $result[0]['label']);
        $this->assertSame('/', $result[0]['link']);
        $this->assertTrue($result[0]['active']);
        $this->assertFalse($result[0]['disabled']);

        $this->assertSame('About', $result[1]['label']);
        $this->assertFalse($result[1]['active']);
        $this->assertTrue($result[1]['disabled']);
    }

    public function testMenuDataWithSubItems(): void
    {
        $result = Normalizer::menuData(
            [
                [
                    'label' => 'Parent',
                    'link' => '#',
                    'items' => [
                        ['label' => 'Child', 'link' => '/child'],
                    ],
                ],
            ],
            '/child',
            true,
        );

        $this->assertSame('Parent', $result[0]['label']);
        $this->assertCount(1, $result[0]['items']);
        $this->assertTrue($result[0]['items'][0]['active']);
    }

    public function testMenuDataLabelNotEncoded(): void
    {
        $result = Normalizer::menuData(
            [['label' => 'A & B', 'link' => '#']],
            '',
            false,
        );

        $this->assertSame('A & B', $result[0]['label']);
    }

    public function testMenuDataStringItemsPassThrough(): void
    {
        $result = Normalizer::menuData(
            [
                ['label' => 'Item', 'link' => '#'],
                'raw-string',
            ],
            '',
            false,
        );

        $this->assertSame('raw-string', $result[1]);
    }

    public function testDropdownData(): void
    {
        $result = Normalizer::dropdownData([
            ['label' => 'Action', 'link' => '#', 'active' => true],
            '-',
            ['label' => 'Other'],
        ]);

        $this->assertSame('Action', $result[0]['label']);
        $this->assertTrue($result[0]['active']);
        $this->assertSame('-', $result[1]);
        $this->assertSame('/', $result[2]['link']);
    }

    public function testDropdownDataWithIcons(): void
    {
        $result = Normalizer::dropdownData([
            ['label' => 'Home', 'link' => '#', 'icon' => '🏠', 'iconClass' => 'bi', 'iconAttributes' => ['id' => 'i']],
        ]);

        $this->assertSame('🏠', $result[0]['icon']);
        $this->assertSame('bi', $result[0]['iconClass']);
        $this->assertSame(['id' => 'i'], $result[0]['iconAttributes']);
    }

    public function testDropdownDataWithSubItems(): void
    {
        $result = Normalizer::dropdownData([
            [
                'label' => 'Parent',
                'link' => '#',
                'items' => [
                    ['label' => 'Child', 'link' => '/child'],
                ],
            ],
        ]);

        $this->assertCount(1, $result[0]['items']);
        $this->assertSame('Child', $result[0]['items'][0]['label']);
    }
}
