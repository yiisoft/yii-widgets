<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\NoEncode;
use Yiisoft\Yii\Widgets\Menu;
use Yiisoft\Yii\Widgets\Tests\Support\StringableObject;
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

    public static function dataLabelExceptionEmptyString(): iterable
    {
        yield 'string' => [''];
        yield 'stringable' => [new StringableObject('')];
        yield 'no-encode-stringable' => [NoEncode::string('')];
    }

    #[DataProvider('dataLabelExceptionEmptyString')]
    public function testLabelExceptionEmptyString(string|Stringable $label): void
    {
        $widget = Menu::widget()->items([['label' => $label]]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" cannot be an empty string.');
        $widget->render();
    }

    public function testLabelExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option must be a string or a Stringable object.');
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
