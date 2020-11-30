<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Widgets\Block;

final class BlockTest extends TestCase
{
    public function testBlock(): void
    {
        Block::widget()
            ->id('testme')
            ->begin();

        echo '<block-testme>';

        Block::end();

        $this->assertStringContainsString('<block-testme>', $this->webView->getBlock('testme'));
    }

    public function testBlockRenderInPlaceTrue(): void
    {
        Block::widget()
            ->id('testme')
            ->renderInPlace(true)
            ->begin();

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
