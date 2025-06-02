<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Block;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Block;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;

final class BlockTest extends TestCase
{
    use TestTrait;

    public function testBlock(): void
    {
        Block::widget()->id('testme')->begin();
        echo '<block-testme>';
        Block::end();

        $this->assertStringContainsString('<block-testme>', $this->webView->getBlock('testme'));
    }

    public function testBlockRenderInPlaceTrue(): void
    {
        Block::widget()->id('testme')->renderInPlace()->begin();
        echo '<block-testme>';
        $html = Block::end();

        $this->assertStringContainsString('<block-testme>', $html);
    }

    public function testZeroContent(): void
    {
        Block::widget()->id('test')->begin();
        echo '0';
        $result = Block::end();

        assertSame('', $result);
        assertSame('0', $this->webView->getBlock('test'));
    }

    public function testEmptyContent(): void
    {
        Block::widget()->id('test')->begin();
        $result = Block::end();

        assertSame('', $result);
        assertFalse($this->webView->hasBlock('test'));
    }
}
