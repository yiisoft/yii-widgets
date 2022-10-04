<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class DropdownTest extends TestCase
{
    use TestTrait;

    private array $items = [
        ['label' => 'Action', 'link' => '#', 'active' => true],
        ['label' => 'Another action', 'link' => '#'],
        ['label' => 'Something else here', 'link' => '#'],
        '-',
        ['label' => 'Separated link', 'link' => '#', 'disabled' => true],
    ];

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testActiveClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a class="test-active-class" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->activeClass('test-active-class')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->containerAttributes(['class' => 'dropdown'])->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->containerClass('dropdown')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testContainerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <article>
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </article>
            HTML,
            Dropdown::widget()->containerTag('article')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testDisabledClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="test-disabled-class" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->disabledClass('test-disabled-class')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testDividerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a class="active" href="#" aria-current="true">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><span class="dropdown-divider"></span></li>
            <li><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->dividerTag('span')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <a class="active" href="#" aria-current="true">Action</a>
            <a href="#">Another action</a>
            <a href="#">Something else here</a>
            <li><hr class="dropdown-divider"></li>
            <a class="disabled" href="#">Separated link</a>
            </div>
            HTML,
            Dropdown::widget()->itemContainer(false)->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a class="active" href="#" aria-current="true">Action</a></li>
            <li class="test-class"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->itemContainerAttributes(['class' => 'test-class'])->items($this->items)->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a class="active" href="#" aria-current="true">Action</a></li>
            <li class="test-class-2"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class-5"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->itemContainerAttributes(['class' => 'test-class'])
                ->items(
                    [
                        ['label' => 'Action', 'link' => '#', 'active' => true],
                        [
                            'label' => 'Another action',
                            'link' => '#',
                            'itemContainerAttributes' => ['class' => 'test-class-2'],
                        ],
                        ['label' => 'Something else here', 'link' => '#'],
                        '-',
                        [
                            'label' => 'Separated link',
                            'link' => '#', 'disabled' => true,
                            'itemContainerAttributes' => ['class' => 'test-class-5'],
                        ],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li class="test-class"><a class="active" href="#" aria-current="true">Action</a></li>
            <li class="test-class"><a href="#">Another action</a></li>
            <li class="test-class"><a href="#">Something else here</a></li>
            <li class="test-class"><hr class="dropdown-divider"></li>
            <li class="test-class"><a class="disabled" href="#">Separated link</a></li>
            </div>
            HTML,
            Dropdown::widget()->itemContainerClass('test-class')->items($this->items)->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsEncodeDefault(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black &amp; White</a></li>
            </div>
            HTML,
            Dropdown::widget()->items([['label' => 'Black & White']])->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsEncodeWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black & White</a></li>
            </div>
            HTML,
            Dropdown::widget()->items([['label' => 'Black & White', 'encode' => false]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i>🏠</i></span>Home</a></li>
            <li><a href="#"><span><i>📧</i></span>Contact</a></li>
            <li><a href="#"><span><i>🔑</i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'icon' => '🏠'],
                    ['label' => 'Contact', 'link' => '#', 'icon' => '📧'],
                    ['label' => 'Login', 'link' => '#', 'icon' => '🔑'],
                ])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsIconAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Home', 'link' => '/active', 'iconAttributes' => ['class' => 'bi bi-house']],
                        ['label' => 'Contact', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-envelope']],
                        ['label' => 'Login', 'link' => '#', 'iconAttributes' => ['class' => 'bi bi-lock']],
                    ]
                )->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsIconClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                    ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                    ['label' => 'Login', 'link' => '#', 'iconClass' => 'bi bi-lock'],
                ])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsIconContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i class="bi bi-house"></i></span>Home</a></li>
            <li><a href="#"><span><i class="bi bi-envelope"></i></span>Contact</a></li>
            <li><a href="#"><span class="test-class-1"><i class="bi bi-lock"></i></span>Login</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/active', 'iconClass' => 'bi bi-house'],
                    ['label' => 'Contact', 'link' => '#', 'iconClass' => 'bi bi-envelope'],
                    [
                        'label' => 'Login',
                        'link' => '#',
                        'iconClass' => 'bi bi-lock',
                        'iconContainerAttributes' => ['class' => 'test-class-1'],
                    ],
                ])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsIconWithEmptyStringLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/active"><span><i>🏠</i></span></a></li>
            <li><a href="#"><span><i>📧</i></span></a></li>
            <li><a href="#"><span><i>🔑</i></span></a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => '', 'link' => '/active', 'icon' => '🏠'],
                    ['label' => '', 'link' => '#', 'icon' => '📧'],
                    ['label' => '', 'link' => '#', 'icon' => '🔑'],
                ])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsLinkAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a class="text-danger" href="/">Black &amp; White</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items([['label' => 'Black & White', 'linkAttributes' => ['class' => 'text-danger']]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testItemsVisible(): void
    {
        $this->assertEmpty(
            Dropdown::widget()->items([['label' => 'Black & White', 'visible' => false]])->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/">Black &amp; White</a></li>
            <li><a href="/">Green &amp; Blue</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    [
                        ['label' => 'Black & White'],
                        ['label' => 'Red & Yellow', 'visible' => false],
                        ['label' => 'Green & Blue', 'visible' => true],
                    ]
                )
                ->render(),
        );
    }
}
