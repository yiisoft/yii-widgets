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
    public function testCssClasses(): void
    {
        $this->assertSame('nav active', Normalizer::cssClasses('nav active'));
        $this->assertSame('nav active', Normalizer::cssClasses(['nav', 'active']));
        $this->assertSame('nav', Normalizer::cssClasses(['nav' => true, 'active' => false]));
        $this->assertSame('nav active', Normalizer::cssClasses(['nav', 'active' => true, 'dark' => false]));
        $this->assertSame('', Normalizer::cssClasses([]));
    }

    public function testRenderLabel(): void
    {
        $this->assertSame('test', Normalizer::renderLabel('test', '', [], '', []));
    }
}
