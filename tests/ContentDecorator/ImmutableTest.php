<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\ContentDecorator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\ContentDecorator;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ImmutableTest extends TestCase
{
    use TestTrait;

    public function testImmutable(): void
    {
        $contentDecorator = ContentDecorator::widget();
        $this->assertNotSame($contentDecorator, $contentDecorator->parameters([]));
        $this->assertNotSame($contentDecorator, $contentDecorator->viewFile(''));
        $this->assertNotSame($contentDecorator, $contentDecorator->pipe(static fn(ContentDecorator $c) => $c->viewFile('test')));
    }
}
