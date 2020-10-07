<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Widgets\Block;

final class BlockTest extends TestCase
{
    public function testBlock(): void
    {
        Block::begin()
            ->id('testme')
            ->start();

        echo '<block-testme>';

        Block::end();

        $this->assertStringContainsString('<block-testme>', $this->webView->getBlock('testme'));
    }

    public function testBlockRenderInPlaceTrue(): void
    {
        Block::begin()
            ->id('testme')
            ->renderInPlace(true)
            ->start();

        echo '<block-testme>';

        $html = Block::end();

        $this->assertStringContainsString('<block-testme>', $html);
    }

    public function testGetBlockException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->webView->getBlock('notfound');
    }
}
