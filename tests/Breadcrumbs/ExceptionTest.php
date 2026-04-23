<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testHomeItemThrowExceptionForEmptyArray(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The home item cannot be an empty array. To disable rendering of the home item, specify null.',
        );
        Breadcrumbs::widget()->homeItem([]);
    }

    public function testLabelNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" element must be a string.');
        Breadcrumbs::widget()->items([['label' => 1]])->render();
    }

    public function testContainerTag(): void
    {
        $widget = Breadcrumbs::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name must be a string and cannot be empty.');
        $widget->containerTag('');
    }

    public function testRenderItem(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" element is required for each item.');
        Breadcrumbs::widget()->homeItem(null)->items([['url' => 'http://my.example.com/yii2/link/page']])->render();
    }
}
