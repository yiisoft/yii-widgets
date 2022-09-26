<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutable(): void
    {
        $breadcrumbs = Breadcrumbs::widget();
        $this->assertNotSame($breadcrumbs, $breadcrumbs->activeItemTemplate(''));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->attributes([]));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->homeItem(null));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->items(['label' => 'value']));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->itemTemplate(''));
        $this->assertNotSame($breadcrumbs, $breadcrumbs->tag('ul'));
    }
}
