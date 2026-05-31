<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Alert;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Alert;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class BulmaTest extends TestCase
{
    use TestTrait;

    /**
     * @link https://bulma.io/documentation/elements/notification/
     */
    public function testNotification(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" class="notification is-danger" id="w0-alert">
            <span>An example alert with an icon.</span>
            <button class="delete" aria-label="Close" type="button">&times;</button>
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

    public function testNotificationWithIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" class="notification is-danger" id="w0-alert">
            <button class="delete" aria-label="Close" type="button">&times;</button>
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
