<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class ImmutableTest extends TestCase
{
    use TestTrait;

    public function testImmutable(): void
    {
        $breadcrumbs = Breadcrumbs::widget();
        $this->assertNotSame($breadcrumbs, $breadcrumbs->activeItemTemplate(''));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->attributes([]));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->homeItem(null));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->id('test'));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->items(['label' => 'value']));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->itemTemplate(''));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->tag('ul'));
    }
}
