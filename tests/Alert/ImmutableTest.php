<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Alert;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Alert;
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
        $alert = Alert::widget();
        $this->assertNotSame($alert, $alert->attributes([]));
        $this->assertNotSame($alert, $alert->body(''));
        $this->assertNotSame($alert, $alert->bodyAttributes([]));
        $this->assertNotSame($alert, $alert->bodyClass(''));
        $this->assertNotSame($alert, $alert->bodyTag());
        $this->assertNotSame($alert, $alert->bodyContainerAttributes([]));
        $this->assertNotSame($alert, $alert->bodyContainer(false));
        $this->assertNotSame($alert, $alert->buttonAttributes([]));
        $this->assertNotSame($alert, $alert->buttonClass(''));
        $this->assertNotSame($alert, $alert->buttonLabel());
        $this->assertNotSame($alert, $alert->buttonOnClick(''));
        $this->assertNotSame($alert, $alert->class(''));
        $this->assertNotSame($alert, $alert->id(''));
        $this->assertNotSame($alert, $alert->header(''));
        $this->assertNotSame($alert, $alert->headerAttributes([]));
        $this->assertNotSame($alert, $alert->headerClass(''));
        $this->assertNotSame($alert, $alert->headerContainer(false));
        $this->assertNotSame($alert, $alert->headerContainerAttributes([]));
        $this->assertNotSame($alert, $alert->headerContainerClass(''));
        $this->assertNotSame($alert, $alert->headerTag('div'));
        $this->assertNotSame($alert, $alert->iconAttributes([]));
        $this->assertNotSame($alert, $alert->iconClass(''));
        $this->assertNotSame($alert, $alert->iconContainerAttributes([]));
        $this->assertNotSame($alert, $alert->iconContainerClass(''));
        $this->assertNotSame($alert, $alert->iconText(''));
        $this->assertNotSame($alert, $alert->layoutBody(''));
        $this->assertNotSame($alert, $alert->layoutHeader(''));
    }
}
