<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Block;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Yii\Widgets\Block;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testCacheFragmentThrowExceptionIfNotSetId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must assign the "id" using the "id()" setter.');

        Block::widget()->begin();
        echo '<block-testme>';
        Block::end();
    }

    public function testGetBlockNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->webView->getBlock('notfound');
    }
}
