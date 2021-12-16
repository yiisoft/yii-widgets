<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use InvalidArgumentException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Yii\Widgets\Alert;

final class AlertTest extends TestCase
{
    /**
     * @throws InvalidConfigException
     */
    public function testBodyAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <span class="test-class">This is a test.</span>
        <button type="button">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->bodyAttributes(['class' => 'test-class'])
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function testBodyContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <div class="test-class">
        <span>This is a test.</span>
        <button type="button">&times;</button>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->bodyContainer(true)
                ->bodyContainerAttributes(['class' => 'test-class'])
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function testBodyTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Body tag must be a string and cannot be empty.');
        Alert::widget()->bodyTag('');
    }

    /**
     * @throws InvalidConfigException
     */
    public function testBodyWithoutTag(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        This is a test.
        <button type="button">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()->body('This is a test.')->bodyTag(null)->id('w0-alert')->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#additional-content
     *
     * @throws InvalidConfigException
     */
    public function testBootstrap5AditionalContent(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Well done!</h4>
        <span><p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
        <hr>
        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy</p></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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
     * @throws InvalidConfigException
     */
    public function testBootstrap5Dismising(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-warning alert-dismissible fade show" role="alert">
        <span><strong>Holy guacamole!</strong> You should check in on some of those fields below.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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
     * @throws InvalidConfigException
     */
    public function testBootstrap5Icon(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-primary alert-dismissible fade show" role="alert">
        <div class="align-items-center d-flex">
        <div><i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i></div>
        <span>An example alert with an icon</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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
     * @throws InvalidConfigException
     */
    public function testBootstrap5LinkColor(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-primary" role="alert">
        <span>A simple primary alert with <a href="#" class="alert-link">an example link</a>.Give it a click if you like.</span>
        <button type="button" class="float-right" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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

    /**
     * @throws InvalidConfigException
     */
    public function testHeaderAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <span class="tests-class">Header title</span>
        <span>This is a test.</span>
        <button type="button">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->header('Header title')
                ->headerAttributes(['class' => 'tests-class'])
                ->id('w0-alert')
                ->layoutHeader('{header}')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function testHeaderContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <div class="test-class">
        <span>Header title</span>
        </div>
        <span>This is a test.</span>
        <button type="button">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->header('Header title')
                ->headerContainer()
                ->headerContainerAttributes(['class' => 'test-class'])
                ->id('w0-alert')
                ->layoutHeader('{header}')
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function testIconAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <div><i class="tests-class"></i></div>
        <span>This is a test.</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->iconAttributes(['class' => 'tests-class'])
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->render()
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function testIconContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <div class="test-container-class"><i class="tests-class"></i></div>
        <span>This is a test.</span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('This is a test.')
                ->iconAttributes(['class' => 'tests-class'])
                ->iconContainerAttributes(['class' => 'test-container-class'])
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->render(),
        );
    }

    /**
     * @link https://bulma.io/documentation/elements/notification/
     *
     * @throws InvalidConfigException
     */
    public function testNotificationBulma(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="notification is-danger" role="alert">
        <span>An example alert with an icon.</span>
        <button type="button" class="delete">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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
     * @throws InvalidConfigException
     */
    public function testNotificationWithIconBulma(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="notification is-danger" role="alert">
        <button type="button" class="delete">&times;</button>
        <div class="is-flex is-align-items-center">
        <div><i class="fa-2x fas fa-exclamation-circle mr-4"></i></div>
        <span>An example alert with an icon.</span>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
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

    /**
     * @throws InvalidConfigException
     */
    public function testHeaderTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Header tag must be a string and cannot be empty.');
        Alert::widget()->headerTag('');
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#banner
     *
     * @throws InvalidConfigException
     */
    public function testTailwindBanner(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-blue-100 border-b border-blue-500 border-t px-4 py-3 text-blue-700" role="alert">
        <span class="align-middle inline-block mr-8"><p class="font-bold">Informational message</p><p class="text-sm">Some additional text to explain said message.</p></span>
        <button type="button" class="float-right px-4 py-3" onclick="closeAlert()">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body(
                    '<p class="font-bold">Informational message</p>' .
                    '<p class="text-sm">Some additional text to explain said message.</p>'
                )
                ->bodyClass('align-middle inline-block mr-8')
                ->buttonClass('float-right px-4 py-3')
                ->buttonOnClick('closeAlert()')
                ->class('bg-blue-100 border-b border-blue-500 border-t px-4 py-3 text-blue-700')
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#left-accent-border
     *
     * @throws InvalidConfigException
     */
    public function testTailwindLeftAccentBorder(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-yellow-100 border-l-2 border-yellow-500 p-4 text-yellow-700" role="alert">
        <span class="align-middle inline-block mr-8"><p><b>Be Warned</b></p> <p>Something not ideal might be happening.</p></span>
        <button type="button" class="absolute bottom-0 px-4 py-3 right-0 top-0" onclick="closeAlert()">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('<p><b>Be Warned</b></p> <p>Something not ideal might be happening.</p>')
                ->bodyClass('align-middle inline-block mr-8')
                ->buttonClass('absolute bottom-0 px-4 py-3 right-0 top-0')
                ->buttonOnClick('closeAlert()')
                ->class('bg-yellow-100 border-l-2 border-yellow-500 p-4 text-yellow-700')
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#modern-with-badge
     *
     * @throws InvalidConfigException
     */
    public function testTailwindModernWithBadge(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-gray-900 lg:px-4 py-4 text-center text-white" role="alert">
        <button type="button" class="bottom-0 px-4 py-3 right-0 top-0" onclick="closeAlert()">&times;</button>
        <div class="bg-gray-800 p-2 flex items-center leading-none lg:inline-flex lg:rounded-full">
        <div class="bg-gray-500 flex font-bold ml-2 mr-3 px-2 py-1 rounded-full text-xs uppercase"><i class="not-italic">🔔 New </i></div>
        <span class="flex-auto font-semibold mr-2 text-left">Get the coolest t-shirts from our brand new store</span>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('Get the coolest t-shirts from our brand new store')
                ->bodyClass('flex-auto font-semibold mr-2 text-left')
                ->bodyContainer(true)
                ->bodyContainerClass('bg-gray-800 p-2 flex items-center leading-none lg:inline-flex lg:rounded-full')
                ->buttonClass('bottom-0 px-4 py-3 right-0 top-0')
                ->buttonOnClick('closeAlert()')
                ->class('bg-gray-900 lg:px-4 py-4 text-center text-white')
                ->iconClass('not-italic')
                ->iconContainerClass('bg-gray-500 flex font-bold ml-2 mr-3 px-2 py-1 rounded-full text-xs uppercase')
                ->iconText('🔔 New ')
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->layoutHeader('{button}')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#solid
     *
     * @throws InvalidConfigException
     */
    public function testTailwindSolid(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-blue-500 flex font-bold items-center px-4 py-3 text-sm text-white" role="alert">
        <div><i class="pr-2">i</i></div>
        <p class="align-middle flex-grow inline-block mr-8">Something happened that you should know about.</p>
        <button type="button" class="float-right px-4 py-3" onclick="closeAlert()">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('Something happened that you should know about.')
                ->bodyClass('align-middle flex-grow inline-block mr-8')
                ->bodyTag('p')
                ->buttonClass('float-right px-4 py-3')
                ->buttonOnClick('closeAlert()')
                ->class('bg-blue-500 flex font-bold items-center px-4 py-3 text-sm text-white')
                ->iconClass('pr-2')
                ->iconText('i')
                ->id('w0-alert')
                ->layoutBody('{icon}{body}{button}')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#traditional
     *
     * @throws InvalidConfigException
     */
    public function testTailwindTraditional(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="align-middle inline-block mr-8"><b>Holy smokes!</b> Something seriously bad happened.</span>
        <button type="button" class="absolute bottom-0 px-4 py-3 right-0 top-0" onclick="closeAlert()">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('<b>Holy smokes!</b> Something seriously bad happened.')
                ->bodyClass('align-middle inline-block mr-8')
                ->buttonClass('absolute bottom-0 px-4 py-3 right-0 top-0')
                ->buttonOnClick('closeAlert()')
                ->class('bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative')
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#titled
     *
     * @throws InvalidConfigException
     */
    public function testTailwindTitled(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" role="alert">
        <div class="bg-red-500 font-bold px-4 py-2 rounded-t text-white">
        <span class="font-semibold">Danger</span>
        </div>
        <div class="bg-red-100 border border-red-400 border-t-0 rounded-b text-red-700">
        <span class="align-middle inline-block mr-8 px-4 py-3">Something not ideal might be happening.</span>
        <button type="button" class="float-right px-4 py-3" onclick="closeAlert()">&times;</button>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->body('Something not ideal might be happening.')
                ->bodyClass('align-middle inline-block mr-8 px-4 py-3')
                ->bodyContainer(true)
                ->bodyContainerClass('bg-red-100 border border-red-400 border-t-0 rounded-b text-red-700')
                ->buttonClass('float-right px-4 py-3')
                ->buttonOnClick('closeAlert()')
                ->header('Danger')
                ->headerClass('font-semibold')
                ->headerContainer()
                ->headerContainerClass('bg-red-500 font-bold px-4 py-2 rounded-t text-white')
                ->id('w0-alert')
                ->layoutHeader('{header}')
                ->render(),
        );
    }

    /**
     * @link https://v1.tailwindcss.com/components/alerts#top-accent-border
     *
     * @throws InvalidConfigException
     */
    public function testTailwindTopAccentBorder(): void
    {
        $expected = <<<'HTML'
        <div id="w0-alert" class="bg-green-100 border-t-4 border-green-500 px-4 py-3 rounded-b shadow-md text-green-900" role="alert">
        <div class="flex">
        <div class="fill-current h-6 mr-4 py-1 text-green-500 w-6"><i class="not-italic">🛈</i></div>
        <span class="align-middle inline-block flex-grow mr-8"><p class="font-bold">Our privacy policy has changed</p><p class="text-sm">Make sure you know how these changes affect you.</p></span>
        <button type="button" class="float-right px-4 py-3" onclick="closeAlert()">&times;</button>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Alert::widget()
                ->attributes(['id' => 'w0-alert'])
                ->body(
                    '<p class="font-bold">Our privacy policy has changed</p>' .
                    '<p class="text-sm">Make sure you know how these changes affect you.</p>'
                )
                ->bodyClass('align-middle inline-block flex-grow mr-8')
                ->bodyContainer(true)
                ->bodyContainerClass('flex')
                ->buttonClass('float-right px-4 py-3')
                ->buttonOnClick('closeAlert()')
                ->class('bg-green-100 border-t-4 border-green-500 px-4 py-3 rounded-b shadow-md text-green-900')
                ->iconClass('not-italic')
                ->iconContainerClass('fill-current h-6 mr-4 py-1 text-green-500 w-6')
                ->iconText('🛈')
                ->layoutBody('{icon}{body}{button}')
                ->render(),
        );
    }

    public function testGenerateId(): void
    {
        $expected = <<<'HTML'
        <div id="alert-1" role="alert">
        <span>This is a test.</span>
        <button type="button">&times;</button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Alert::widget()->body('This is a test.')->render());
    }
}
