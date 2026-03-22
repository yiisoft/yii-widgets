<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testAfterTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->afterTag('')->afterContent('tests')->items([['label' => 'Item 1']])->render();
    }

    public function testBeforeTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->beforeTag('')->beforeContent('tests')->items([['label' => 'Item 1']])->render();
    }

    public function testDropdownContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()
            ->dropdownContainerTag('')
            ->items([
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
            ])
            ->render();
    }

    public function testItemsTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->itemsTag('')->render();
    }

    public function testLabelExceptionEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Menu::widget()->items([['link' => '/home']])->render();
    }

    public function testLabelExceptionEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" cannot be an empty string.');
        Menu::widget()->items([['label' => '']])->render();
    }

    public function testLabelExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option must be a string.');
        Menu::widget()->items([['label' => 1]])->render();
    }

    public function testLinkTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->linkTag('')->render();
    }

    public function testTagName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Menu::widget()->items([['label' => 'Item 1']])->tagName('')->render();
    }
}
