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
final class AlertTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testBodyAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span class="test-class">This is a test.</span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->bodyAttributes(['class' => 'test-class'])
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testBodyContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <div class="test-class">
            <span>This is a test.</span>
            <button type="button">&times;</button>
            </div>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->bodyContainer(true)
                ->bodyContainerAttributes(['class' => 'test-class'])
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testBodyWithoutTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            This is a test.
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->bodyTag()
                ->id('w0-alert')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testGenerateId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="alert-1" role="alert">
            <span>This is a test.</span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()->body('This is a test.')->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span class="tests-class">Header title</span>
            <span>This is a test.</span>
            <button type="button">&times;</button>
            </div>
            HTML,
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
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testHeaderContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <div class="test-class">
            <span>Header title</span>
            </div>
            <span>This is a test.</span>
            <button type="button">&times;</button>
            </div>
            HTML,
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
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testIconAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <div><i class="tests-class"></i></div>
            <span>This is a test.</span>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->iconAttributes(['class' => 'tests-class'])
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testIconContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <div class="test-container-class"><i class="tests-class"></i></div>
            <span>This is a test.</span>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->iconAttributes(['class' => 'tests-class'])
                ->iconContainerAttributes(['class' => 'test-container-class'])
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->render(),
        );
    }

    public function testHeaderWithHtmlContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span><b>Bold</b></span>
            <span>Body</span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->header('<b>Bold</b>')
                ->id('w0-alert')
                ->layoutHeader('{header}')
                ->render(),
        );
    }

    public function testIconBeforeBodyNewline(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span>Body</span>
            <div><i class="ic"></i></div>
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->iconAttributes(['class' => 'ic'])
                ->id('w0-alert')
                ->layoutBody('{body}{icon}')
                ->render(),
        );
    }

    public function testHeaderContainerTrimsWhitespace(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span>H</span>
            <span>Body</span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->header('H')
                ->id('w0-alert')
                ->layoutHeader(' {header} ')
                ->render(),
        );
    }
}
