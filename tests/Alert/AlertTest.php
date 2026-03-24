<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Alert;

use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Widgets\Alert;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class AlertTest extends TestCase
{
    use TestTrait;

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

    public function testBodyList(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span><ul><li>Error 1</li><li>Error 2</li></ul></span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body(['Error 1', 'Error 2'])
                ->id('w0-alert')
                ->render(),
        );
    }

    public function testBodyListClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span><ul class="error-list"><li>Error 1</li></ul></span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body(['Error 1'])
                ->bodyListClass('error-list')
                ->id('w0-alert')
                ->render(),
        );
    }

    public function testBodyListCustomTags(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div role="alert" id="w0-alert">
            <span><ol><p>Error 1</p><p>Error 2</p></ol></span>
            <button type="button">&times;</button>
            </div>
            HTML,
            Alert::widget()
                ->body(['Error 1', 'Error 2'])
                ->bodyListTag('ol')
                ->bodyListItemTag('p')
                ->id('w0-alert')
                ->render(),
        );
    }

    public function testBodyListEmpty(): void
    {
        $this->assertEmpty(
            Alert::widget()
                ->body([])
                ->id('w0-alert')
                ->render(),
        );
    }

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
