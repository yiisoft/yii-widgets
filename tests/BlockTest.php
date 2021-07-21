<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use InvalidArgumentException;
use RuntimeException;
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

    public function testCacheFragmentThrowExceptionIfNotSetId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must assign the "id" using the "id()" setter.');

        Block::widget()->begin();

        echo '<block-testme>';

        Block::end();
    }

    public function testGetBlockException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->webView->getBlock('notfound');
    }

    public function testImmutability(): void
    {
        $widget = Block::widget();

        $this->assertNotSame($widget, $widget->id(Block::class));
        $this->assertNotSame($widget, $widget->renderInPlace(false));
    }
}
