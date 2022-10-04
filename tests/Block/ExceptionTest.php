<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Block;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Block;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ExceptionTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     * @throws RuntimeException
     */
    public function testCacheFragmentThrowExceptionIfNotSetId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must assign the "id" using the "id()" setter.');

        Block::widget()->begin();
        echo '<block-testme>';
        Block::end();
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testGetBlockNotFound(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->webView->getBlock('notfound');
    }
}
