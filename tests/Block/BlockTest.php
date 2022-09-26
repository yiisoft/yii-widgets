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
final class BlockTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testBlock(): void
    {
        Block::widget()->id('testme')->begin();
        echo '<block-testme>';
        Block::end();

        $this->assertStringContainsString('<block-testme>', $this->webView->getBlock('testme'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testBlockRenderInPlaceTrue(): void
    {
        Block::widget()->id('testme')->renderInPlace()->begin();
        echo '<block-testme>';
        $html = Block::end();

        $this->assertStringContainsString('<block-testme>', $html);
    }
}
