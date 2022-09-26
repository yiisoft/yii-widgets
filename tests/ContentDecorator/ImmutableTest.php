<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\ContentDecorator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\ContentDecorator;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotInstantiableException|NotFoundException
     */
    public function testImmutable(): void
    {
        $contentDecorator = ContentDecorator::widget();
        $this->assertNotSame($contentDecorator, $contentDecorator->parameters([]));
        $this->assertNotSame($contentDecorator, $contentDecorator->viewFile(''));
    }
}
