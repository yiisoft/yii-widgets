<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Dropdown;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\IdGenerator;
use Yiisoft\Yii\Widgets\Dropdown;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

final class PruneItemsTest extends TestCase
{
    use TestTrait {
        TestTrait::setUp as setUpTestTrait;
    }

    private const HIDDEN = ['label' => 'Users', 'link' => '/users', 'visible' => false];

    protected function setUp(): void
    {
        $this->setUpTestTrait();

        IdGenerator\disableSeed();
        IdGenerator\reset();
    }

    public function testDisabledByDefault(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            <button id="dropdown-1" type="button">Admin</button>
            <ul aria-labelledby="dropdown-1">
            <li><hr class="dropdown-divider"></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items([
                    ['label' => 'A', 'link' => '/a'],
                    ['label' => 'Admin', 'items' => [self::HIDDEN, '-']],
                ])
                ->render(),
        );
    }

    public function testRemovesSubmenuWithHiddenItemsOnly(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'A', 'link' => '/a'],
                    ['label' => 'Admin', 'items' => [self::HIDDEN]],
                ])
                ->render(),
        );
    }

    public function testRemovesSubmenuWithDividersOnly(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'A', 'link' => '/a'],
                    ['label' => 'Admin', 'items' => ['-', ['label' => '-'], self::HIDDEN]],
                ])
                ->render(),
        );
    }

    public function testRemovesSubmenuWithOwnLinkWhenItsItemsAreRemoved(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'A', 'link' => '/a'],
                    ['label' => 'Admin', 'link' => '/admin', 'items' => [self::HIDDEN]],
                ])
                ->render(),
        );
    }

    public function testRemovesParentWhenNestedSubmenuBecomesEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'A', 'link' => '/a'],
                    [
                        'label' => 'Admin',
                        'items' => [
                            '-',
                            ['label' => 'Users', 'items' => [self::HIDDEN, '-']],
                        ],
                    ],
                ])
                ->render(),
        );
    }

    public function testKeepsSubmenuWithContentAndPrunesItsItems(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <button id="dropdown-1" type="button">Admin</button>
            <ul aria-labelledby="dropdown-1">
            <li><a href="/settings">Settings</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    [
                        'label' => 'Admin',
                        'items' => [
                            '-',
                            ['label' => 'Users', 'items' => [self::HIDDEN]],
                            ['label' => 'Settings', 'link' => '/settings'],
                            ['label' => '-'],
                        ],
                    ],
                ])
                ->render(),
        );
    }

    public function testTrimsAndCollapsesDividers(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="/b">B</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    '-',
                    ['label' => '-'],
                    ['label' => 'A', 'link' => '/a'],
                    '-',
                    self::HIDDEN,
                    ['label' => '-'],
                    '-',
                    ['label' => 'B', 'link' => '/b'],
                    '-',
                ])
                ->render(),
        );
    }

    public function testRendersNothingWhenOnlyDividersRemain(): void
    {
        $this->assertSame(
            '',
            Dropdown::widget()
                ->pruneItems()
                ->filter(static fn(array $item): bool => false)
                ->items([['label' => 'A', 'link' => '/a'], '-', ['label' => '-']])
                ->render(),
        );
    }

    public function testKeepsLeafItemsHeadersDisabledAndRawContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/b">B</a></li>
            <li><span>Section</span></li>
            <li><a aria-disabled="true" class="disabled" href="/disabled">Disabled</a></li>
            <em>Content</em>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'B', 'link' => '/b', 'items' => []],
                    ['label' => 'Section', 'link' => ''],
                    ['label' => 'Disabled', 'link' => '/disabled', 'disabled' => true],
                    ['label' => '<em>Content</em>', 'encode' => false, 'enclose' => false],
                ])
                ->render(),
        );
    }

    public function testKeepsSubmenuWithHeaderOnly(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <button id="dropdown-1" type="button">Admin</button>
            <ul aria-labelledby="dropdown-1">
            <li><span>Section</span></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([['label' => 'Admin', 'items' => [['label' => 'Section', 'link' => ''], '-']]])
                ->render(),
        );
    }

    public function testHyphenLabelWithIconIsNotDivider(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/"><span><i class="icon-star"></i></span>-</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([['label' => '-', 'iconClass' => 'icon-star']])
                ->render(),
        );
    }

    public function testKeepsEscapingAndToggleAria(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <button id="admin-toggle" type="button">&lt;b&gt;Admin&lt;/b&gt;</button>
            <ul aria-labelledby="admin-toggle">
            <li><a href="/a">A &amp; B</a></li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->items([
                    [
                        'label' => '<b>Admin</b>',
                        'toggleAttributes' => ['id' => 'admin-toggle'],
                        'items' => ['-', ['label' => 'A & B', 'link' => '/a'], self::HIDDEN],
                    ],
                ])
                ->render(),
        );
    }

    public function testFilterCallbackIsCalledForTheSameItems(): void
    {
        $items = [
            ['label' => 'A', 'link' => '/a'],
            '-',
            ['label' => 'Admin', 'items' => [['label' => 'X', 'link' => '/x', 'admin' => true], '-']],
        ];
        $calls = [];
        $filter = static function (array $item) use (&$calls): bool {
            $calls[] = $item['label'];
            return empty($item['admin']);
        };

        Dropdown::widget()->filter($filter)->items($items)->render();
        $withoutPruning = $calls;
        $calls = [];
        $html = Dropdown::widget()->filter($filter)->pruneItems()->items($items)->render();

        $this->assertSame($withoutPruning, $calls);
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            $html,
        );
    }

    public function testRendersTheSameOnRepeatedRendering(): void
    {
        $items = ['-', ['label' => 'A', 'link' => '/a'], '-', '-', ['label' => 'B', 'link' => '/b']];
        $dropdown = Dropdown::widget()->pruneItems()->items($items);

        $this->assertSame($dropdown->render(), $dropdown->render());
    }

    public function testHiddenItemsAreStillValidated(): void
    {
        $dropdown = Dropdown::widget()
            ->pruneItems()
            ->items([['label' => 'A', 'link' => '/a'], '-', ['link' => '/no-label', 'visible' => false]]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');

        $dropdown->render();
    }

    public function testVisibleItemsWithoutLabelAreStillValidated(): void
    {
        $dropdown = Dropdown::widget()
            ->pruneItems()
            ->items([['label' => 'A', 'link' => '/a'], '-', ['link' => '/no-label']]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');

        $dropdown->render();
    }

    public function testPruneItemsFalseDisablesPruning(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <li><hr class="dropdown-divider"></li>
            <li><a href="/a">A</a></li>
            </div>
            HTML,
            Dropdown::widget()
                ->pruneItems()
                ->pruneItems(false)
                ->items(['-', ['label' => 'A', 'link' => '/a']])
                ->render(),
        );
    }
}
