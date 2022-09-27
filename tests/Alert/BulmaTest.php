<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Alert;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Alert;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class BulmaTest extends TestCase
{
    use TestTrait;

    /**
     * @link https://bulma.io/documentation/elements/notification/
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testNotification(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="notification is-danger" role="alert">
            <span>An example alert with an icon.</span>
            <button type="button" class="delete">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body('An example alert with an icon.')
                ->buttonClass('delete')
                ->class('notification is-danger')
                ->id('w0-alert')
                ->layoutBody('{body}{button}')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testNotificationWithIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="notification is-danger" role="alert">
            <button type="button" class="delete">&times;</button>
            <div class="is-flex is-align-items-center">
            <div><i class="fa-2x fas fa-exclamation-circle mr-4"></i></div>
            <span>An example alert with an icon.</span>
            </div>
            </div>
            HTML,
            Alert::widget()
                ->body('An example alert with an icon.')
                ->bodyContainer(true)
                ->bodyContainerClass('is-flex is-align-items-center')
                ->buttonClass('delete')
                ->class('notification is-danger')
                ->iconClass('fa-2x fas fa-exclamation-circle mr-4')
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->layoutHeader('{button}')
                ->render(),
        );
    }
}
