<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Alert;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Alert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testBodyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Body tag must be a string and cannot be empty.');
        Alert::widget()->bodyTag('');
    }

    public function testHeaderTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Header tag must be a string and cannot be empty.');
        Alert::widget()->headerTag('');
    }
}
