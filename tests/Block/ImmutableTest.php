<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Block;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Block;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ImmutableTest extends TestCase
{
    use TestTrait;

    public function testImmutable(): void
    {
        $block = Block::widget();
        $this->assertNotSame($block, $block->id(Block::class));
        $this->assertNotSame($block, $block->renderInPlace());
    }
}
