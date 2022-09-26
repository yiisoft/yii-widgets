<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Breadcrumbs;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Breadcrumbs;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class BreadcrumbsTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb external">
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->attributes(['class' => 'breadcrumb external'])
                ->homeItem(null)
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEmptyLinks(): void
    {
        $this->assertEmpty(Breadcrumbs::widget()->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHomeItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li>home-link</li>
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->homeItem(['label' => 'home-link'])
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItems(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">My Home Page</li>
            <li class="active">https://my.example.com/yii/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->items(['label' => 'My Home Page', 'url' => 'https://my.example.com/yii/link/page'])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsWithTemplate(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="https://my.example.com/yii/link/page">Link</a></li>
            <span>Text</span>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->items(
                    [
                        ['label' => 'Link', 'url' => 'https://my.example.com/yii/link/page'],
                        ['label' => 'Text', 'template' => "<span>{link}</span>\n"],
                    ]
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRenderItemLabelOnlyEncodeLabelFalse(): void
    {
        $this->assertSame(
            "<li>My-<br>Test-Label</li>\n",
            Breadcrumbs::widget()
                ->activeItemTemplate("<li>{link}</li>\n")
                ->homeItem(null)
                ->items([['label' => 'My-<br>Test-Label', 'encode' => false]]) // encode label false
                ->tag('')
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRenderItemLabelOnlyEncodeLabelTrue(): void
    {
        $this->assertSame(
            '<li>My-&lt;br&gt;Test-Label</li>',
            Breadcrumbs::widget()
                ->activeItemTemplate('<li>{link}</li>')
                ->homeItem(null)
                ->items(['label' => 'My-<br>Test-Label'])
                ->tag('')
                ->render()
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="breadcrumb">
            <a href="/">Home</a>
            My Home Page
            http://my.example.com/yii2/link/page
            </div>
            HTML,
            Breadcrumbs::widget()
                ->activeItemTemplate("{link}\n")
                ->attributes(['class' => 'breadcrumb'])
                ->items(['label' => 'My Home Page', 'url' => 'http://my.example.com/yii2/link/page'])
                ->itemTemplate("{link}\n")
                ->tag('div')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutHomeItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="breadcrumb">
            <li class="active">My Home Page</li>
            <li class="active">http://my.example.com/yii2/link/page</li>
            </ul>
            HTML,
            Breadcrumbs::widget()
                ->homeItem(null)
                ->items([
                    'label' => 'My Home Page',
                    'url' => 'http://my.example.com/yii2/link/page',
                ])
                ->render(),
        );
    }
}
