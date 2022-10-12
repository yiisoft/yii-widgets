<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Helper\Normalizer;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class NormalizerTest extends TestCase
{
    public function testRenderLabel(): void
    {
        $this->assertSame('test', Normalizer::renderLabel('test', '', [], '', []));
    }
}
