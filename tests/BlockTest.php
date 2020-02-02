<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\Block;

final class BlockTest extends TestCase
{
    public function testBlock(): void
    {
        Block::begin()
            ->id('testme')
            ->init();

        echo '<block-testme>';

        Block::end();

        $this->assertStringContainsString('<block-testme>', $this->webView->getBlock('testme'));
    }

    public function testBlockRenderInPlaceTrue(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Block::begin()
            ->id('testme')
            ->renderInPlace(true)
            ->init();

        echo '<block-testme>';

        echo Block::end();

        $this->assertStringContainsString('<block-testme>', ob_get_clean());
    }

    public function testGetBlockException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->webView->getBlock('notfound');
    }
}
