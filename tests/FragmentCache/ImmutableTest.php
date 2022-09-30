<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\FragmentCache;

use PHPUnit\Framework\TestCase;
use Yiisoft\Cache\Dependency\TagDependency;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Yii\Widgets\FragmentCache;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testImmutable(): void
    {
        $widget = FragmentCache::widget();
        $this->assertNotSame($widget, $widget->id(''));
        $this->assertNotSame($widget, $widget->ttl(3600));
        $this->assertNotSame($widget, $widget->dependency(new TagDependency('test')));
        $this->assertNotSame($widget, $widget->dynamicContents(new DynamicContent('test', fn (): string => 'test')));
        $this->assertNotSame($widget, $widget->variations(''));
    }
}
