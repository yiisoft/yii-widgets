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
final class Bootstrap5Test extends TestCase
{
    use TestTrait;

    /**
     * Add a header to label sections of actions in any dropdown menu.
     *
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#headers
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testHeaders(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group'],
            'headerClass()' => ['dropdown-header'],
            'headerTag()' => ['h6'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-secondary dropdown-toggle'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown</button>
            <ul class="dropdown-menu">
            <li><h6 class="dropdown-header">Dropdown header</h6></li>
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->items(
                    [
                        [
                            'label' => 'Dropdown',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Dropdown header', 'link' => ''],
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->render()
        );
    }

    /**
     * Similarly, create split button dropdowns with virtually the same markup as single button dropdowns, but with the
     * addition of `.dropdown-toggle-split` for proper spacing around the dropdown caret.
     *
     * We use this extra class to reduce the horizontal padding on either side of the caret by 25% and remove the
     * margin-left that’s added for regular button dropdowns. Those extra changes keep the caret centered in the split
     * button and provide a more appropriately sized hit area next to the main button.
     *
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#split-button
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplit(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-danger dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-danger'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-danger">Action</button>
            <button type="button" id="dropdown-example" class="btn btn-danger dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Action</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Action',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('link')
                ->toggleType('split')
                ->render()
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#dropend
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplitDropend(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group dropend'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-secondary dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-secondary'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropend">
            <button type="button" class="btn btn-secondary">Split dropend</button>
            <button type="button" id="dropdown-example" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Split dropend</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Split dropend',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('link')
                ->toggleType('split')
                ->render()
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#dropstart
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplitDropStart(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group dropstart'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-secondary dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-secondary'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropstart">
            <button type="button" id="dropdown-example" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Split dropstart</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            <button type="button" class="btn btn-secondary">Split dropstart</button>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Split dropstart',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('link')
                ->toggleType('split')
                ->render()
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#dropup
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplitDropup(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group dropup'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-secondary dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-secondary'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropup">
            <button type="button" class="btn btn-secondary">Split dropup</button>
            <button type="button" id="dropdown-example" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Split dropup</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Split dropup',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('link')
                ->toggleType('split')
                ->render()
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#sizing
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplitSizingWithLargeButton(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-secondary btn-lg'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-secondary btn-lg">Large split button</button>
            <button type="button" id="dropdown-example" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Large split button</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Large split button',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('split')
                ->render()
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/dropdowns/#sizing
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSplitSizingWithSmallButton(): void
    {
        $definitions = [
            'containerClass()' => ['btn-group'],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
            'toggleClass()' => ['btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split'],
            'splitButtonClass()' => ['btn btn-secondary btn-sm'],
            'splitButtonSpanClass()' => ['visually-hidden'],
        ];

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-secondary btn-sm">Large split button</button>
            <button type="button" id="dropdown-example" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Large split button</span></button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-example">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget($definitions)
                ->id('dropdown-example')
                ->items(
                    [
                        [
                            'label' => 'Large split button',
                            'link' => '#',
                            'items' => [
                                ['label' => 'Action', 'link' => '#'],
                                ['label' => 'Another action', 'link' => '#'],
                                ['label' => 'Something else here', 'link' => '#'],
                                '-',
                                ['label' => 'Separated link', 'link' => '#'],
                            ],
                        ],
                    ]
                )
                ->toggleType('split')
                ->render()
        );
    }
}
