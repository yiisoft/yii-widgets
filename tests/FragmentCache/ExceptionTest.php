<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\FragmentCache;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Yii\Widgets\FragmentCache;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ExceptionTest extends TestCase
{
    use TestTrait;

    public function testCacheFragmentThrowExceptionIfNotSetId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must assign the "id" using the "id()" setter.');

        FragmentCache::widget()->begin();
        echo 'cached fragment';
        FragmentCache::end();
    }
}
