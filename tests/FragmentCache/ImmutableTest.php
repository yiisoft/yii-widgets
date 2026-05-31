<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\FragmentCache;

use PHPUnit\Framework\TestCase;
use Yiisoft\Cache\Dependency\TagDependency;
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Yii\Widgets\FragmentCache;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ImmutableTest extends TestCase
{
    use TestTrait;

    public function testImmutable(): void
    {
        $widget = FragmentCache::widget();
        $this->assertNotSame($widget, $widget->id(''));
        $this->assertNotSame($widget, $widget->ttl(3600));
        $this->assertNotSame($widget, $widget->dependency(new TagDependency('test')));
        $this->assertNotSame($widget, $widget->dynamicContents(new DynamicContent('test', fn(): string => 'test')));
        $this->assertNotSame($widget, $widget->variations(''));
        $this->assertNotSame($widget, $widget->when(true, static fn(FragmentCache $w) => $w->id('test')));
    }
}
