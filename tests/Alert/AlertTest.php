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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testBodyAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testBodyContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testBodyWithoutTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHeaderContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIconAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
            <div><i class="tests-class"></i></div>
            <span>This is a test.</span>
            </div>
            HTML,
            Alert::widget()
                ->body('This is a test.')
                ->iconAttributes(['class' => 'tests-class'])
                ->id('w0-alert')
                ->layoutBody('{icon}{body}')
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIconContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w0-alert" role="alert">
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
}
