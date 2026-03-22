<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->containerTag('')->items([['label' => 'test']])->render();
    }

    public function testHeaderTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()
            ->headerTag('')
            ->items(
                [
                    [
                        'label' => 'Dropdown',
                        'link' => '#',
                        'items' => [
                            ['label' => 'Dropdown header', 'link' => ''],
                            ['label' => 'Action', 'link' => '#'],
                            ['label' => 'Another action', 'link' => '#'],
                        ],
                    ],
                ],
            )
            ->render();
    }

    public function testItemDividerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->dividerTag('')->items([['label' => 'test'], '-'])->render();
    }

    public function testItemContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->itemContainerTag('')->items([['label' => 'test']])->render();
    }

    public function testItemTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->itemTag('')->items([['label' => 'test']])->render();
    }

    public function testItemsContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()
            ->itemsContainerTag('')
            ->items(
                [
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
                ],
            )
            ->render();
    }

    public function testLabelExceptionEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Dropdown::widget()->items([['link' => '/home']])->render();
    }

    public function testLabelExceptionEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" cannot be an empty string.');
        Dropdown::widget()->items([['label' => '']])->render();
    }

    public function testLabelExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option must be a string.');
        Dropdown::widget()->items([['label' => 1]])->render();
    }
}
