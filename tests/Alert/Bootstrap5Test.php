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
final class Bootstrap5Test extends TestCase
{
    use TestTrait;

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#additional-content
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAdditionalContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <span><p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy</p></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body(
                    '<p>Aww yeah, you successfully read this important alert message. This example text is going to run ' .
                    'a bit longer so that you can see how spacing within an alert works with this kind of content.</p>' .
                    PHP_EOL . '<hr>' . PHP_EOL .
                    '<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy</p>'
                )
                ->buttonAttributes(['data-bs-dismiss' => 'alert', 'aria-label' => 'Close'])
                ->buttonClass('btn-close')
                ->buttonLabel()
                ->class('alert alert-success alert-dismissible fade show')
                ->id('w0-alert')
                ->header('Well done!')
                ->headerClass('alert-heading')
                ->headerTag('h4')
                ->layoutHeader('{header}')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#dismissing
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDismissing(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="alert alert-warning alert-dismissible fade show" role="alert">
            <span><strong>Holy guacamole!</strong> You should check in on some of those fields below.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                ->buttonAttributes(['data-bs-dismiss' => 'alert', 'aria-label' => 'Close'])
                ->buttonClass('btn-close')
                ->buttonLabel()
                ->class('alert alert-warning alert-dismissible fade show')
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#icons
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="alert alert-primary alert-dismissible fade show" role="alert">
            <div class="align-items-center d-flex">
            <div><i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i></div>
            <span>An example alert with an icon</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            </div>
            HTML,
            Alert::widget()
                ->body('An example alert with an icon')
                ->bodyContainerClass('align-items-center d-flex')
                ->buttonAttributes(['data-bs-dismiss' => 'alert', 'aria-label' => 'Close'])
                ->bodyContainer(true)
                ->buttonClass('btn-close')
                ->buttonLabel()
                ->class('alert alert-primary alert-dismissible fade show')
                ->iconClass('bi bi-exclamation-triangle-fill flex-shrink-0 me-2')
                ->id('w0-alert')
                ->layoutBody('{icon}{body}{button}')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#link-color
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLinkColor(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" class="alert alert-primary" role="alert">
            <span>A simple primary alert with <a href="#" class="alert-link">an example link</a>.Give it a click if you like.</span>
            <button type="button" class="float-right" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body(
                    'A simple primary alert with <a href="#" class="alert-link">an example link</a>.' .
                    'Give it a click if you like.'
                )
                ->buttonAttributes(['data-bs-dismiss' => 'alert', 'aria-label' => 'Close'])
                ->buttonClass('float-right')
                ->buttonLabel()
                ->class('alert alert-primary')
                ->id('w0-alert')
                ->render(),
        );
    }
}
