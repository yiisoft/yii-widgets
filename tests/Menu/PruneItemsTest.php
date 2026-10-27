<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Menu;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\IdGenerator;
use Yiisoft\Yii\Widgets\Menu;
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
            <ul>
            <li><a href="/home">Home</a></li>
            <li>
            <a aria-expanded="false" data-bs-toggle="dropdown" role="button" id="dropdown-1" href="/">Admin</a>
            <ul aria-labelledby="dropdown-1">
            <li><hr class="dropdown-divider"></li>
            </ul>
            </li>
            </ul>
            HTML,
            Menu::widget()
                ->items([
                    ['label' => 'Home', 'link' => '/home'],
                    ['label' => 'Admin', 'items' => [self::HIDDEN, '-']],
                ])
                ->render(),
        );
    }

    public function testRemovesSubmenuWithHiddenItemsAndDividersOnly(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/home">Home</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->pruneItems()
                ->items([
                    ['label' => 'Home', 'link' => '/home'],
                    ['label' => 'Admin', 'items' => [self::HIDDEN, '-', ['label' => '-']]],
                ])
                ->render(),
        );
    }

    public function testRendersNothingWhenAllSubmenusAreRemoved(): void
    {
        $this->assertSame(
            '',
            Menu::widget()
                ->pruneItems()
                ->items([['label' => 'Admin', 'link' => '/admin', 'items' => [self::HIDDEN, '-']]])
                ->render(),
        );
    }

    public function testPrunesSubmenuItemsAndKeepsActiveState(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li>
            <a aria-expanded="false" data-bs-toggle="dropdown" role="button" id="dropdown-1" href="#">Admin</a>
            <ul aria-labelledby="dropdown-1">
            <li><a aria-current="page" class="active" href="/settings">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="/logs">Logs</a></li>
            </ul>
            </li>
            </ul>
            HTML,
            Menu::widget()
                ->pruneItems()
                ->currentPath('/settings')
                ->items([
                    [
                        'label' => 'Admin',
                        'link' => '#',
                        'items' => [
                            '-',
                            ['label' => 'Settings', 'link' => '/settings'],
                            '-',
                            ['label' => 'Users', 'items' => [self::HIDDEN]],
                            ['label' => '-'],
                            ['label' => 'Logs', 'link' => '/logs'],
                            '-',
                        ],
                    ],
                ])
                ->render(),
        );
    }

    public function testKeepsTopLevelItemsWithoutNestedItems(): void
    {
        $items = [
            ['label' => 'Home', 'link' => '/home', 'items' => []],
            ['label' => 'Hidden', 'link' => '/hidden', 'visible' => false],
            ['label' => '-', 'link' => '/dash'],
            ['label' => 'About', 'link' => '/about'],
        ];

        $this->assertSame(
            Menu::widget()->items($items)->render(),
            Menu::widget()->pruneItems()->items($items)->render(),
        );
    }

    public function testFirstAndLastItemClassesApplyAfterPruning(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li class="first last"><a href="/home">Home</a></li>
            </ul>
            HTML,
            Menu::widget()
                ->pruneItems()
                ->firstItemClass('first')
                ->lastItemClass('last')
                ->items([
                    ['label' => 'Home', 'link' => '/home'],
                    ['label' => 'Admin', 'items' => [self::HIDDEN]],
                ])
                ->render(),
        );
    }

    public function testFilterCallbackIsCalledForTheSameItems(): void
    {
        $items = [
            ['label' => 'Home', 'link' => '/home'],
            ['label' => 'Admin', 'items' => [['label' => 'X', 'link' => '/x', 'admin' => true], '-']],
        ];
        $calls = [];
        $filter = static function (array $item) use (&$calls): bool {
            $calls[] = $item['label'];
            return empty($item['admin']);
        };

        Menu::widget()->filter($filter)->items($items)->render();
        $withoutPruning = $calls;
        $calls = [];
        $html = Menu::widget()->filter($filter)->pruneItems()->items($items)->render();

        $this->assertSame($withoutPruning, $calls);
        Assert::equalsWithoutLE(
            <<<HTML
            <ul>
            <li><a href="/home">Home</a></li>
            </ul>
            HTML,
            $html,
        );
    }
}
