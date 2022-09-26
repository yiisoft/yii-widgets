<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Block;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Block;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutable(): void
    {
        $block = Block::widget();
        $this->assertNotSame($block, $block->id(Block::class));
        $this->assertNotSame($block, $block->renderInPlace());
    }
}
