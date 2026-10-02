<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\NoEncode;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\StringableObject;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->containerTag('');
    }

    public function testHeaderTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->headerTag('');
    }

    public function testItemDividerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->dividerTag('');
    }

    public function testItemContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->itemContainerTag('');
    }

    public function testItemTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->itemTag('');
    }

    public function testItemsContainerTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        Dropdown::widget()->itemsContainerTag('');
    }

    public function testLabelExceptionEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Dropdown::widget()->items([['link' => '/home']])->render();
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
        $widget = Dropdown::widget()->items([['label' => $label]]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" cannot be an empty string.');
        $widget->render();
    }

    public function testLabelExceptionNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option must be a string or a Stringable object.');
        Dropdown::widget()->items([['label' => 1]])->render();
    }
}
