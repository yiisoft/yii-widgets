<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_merge;
use function count;
use function implode;
use function is_string;
use function strtr;
use function trim;

/**
 * Menu displays a multi-level menu using nested HTML lists.
 *
 * The {@see Menu::items()} method specifies the possible items in the menu.
 * A menu item can contain sub-items which specify the sub-menu under that menu item.
 *
 * Menu checks the current route and request parameters to toggle certain menu items with active state.
 *
 * Note that Menu only renders the HTML tags about the menu. It does not do any styling.
 * You are responsible to provide CSS styles to make it look like a real menu.
 *
 * The following example shows how to use Menu:
 *
 * ```php
 * <?= Menu::Widget()
 *     ->items([
 *         ['label' => 'Login', 'link' => 'site/login', 'visible' => true],
 *     ]);
 * ?>
 * ```
 */
final class Menu extends Widget
{
    private array $afterAttributes = [];
    private string $afterContent = '';
    private string $afterTag = 'span';
    private string $activeClass = 'active';
    private bool $activateItems = true;
    private array $attributes = [];
    private array $beforeAttributes = [];
    private string $beforeContent = '';
    private string $beforeTag = 'span';
    private bool $container = true;
    private string $currentPath = '';
    private string $disabledClass = 'disabled';
    private bool $dropdownContainer = true;
    private array $dropdownContainerAttributes = [];
    private string $dropdownContainerTag = 'li';
    private array $dropdownDefinitions = [];
    private string $firstItemClass = '';
    private array $iconContainerAttributes = [];
    private array $items = [];
    private bool $itemsContainer = true;
    private array $itemsContainerAttributes = [];
    private string $itemsTag = 'li';
    private string $lastItemClass = '';
    private array $linkAttributes = [];
    private string $linkClass = '';
    private string $linkTag = 'a';
    private string $tagName = 'ul';
    private string $template = '{items}';

    /**
     * Return new instance with specified whether to activate parent menu items when one of the corresponding child menu
     * items is active.
     *
     * @param bool $value The value to be assigned to the activateItems property.
     */
    public function activateItems(bool $value): self
    {
        $new = clone $this;
        $new->activateItems = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified active CSS class.
     *
     * @param string $value The CSS class to be appended to the active menu item.
     */
    public function activeClass(string $value): self
    {
        $new = clone $this;
        $new->activeClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified after container attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function afterAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->afterAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified after container class.
     *
     * @param string $value The class name.
     */
    public function afterClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->afterAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified after content.
     *
     * @param string|Stringable $content The content.
     */
    public function afterContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->afterContent = (string) $content;

        return $new;
    }

    /**
     * Returns a new instance with the specified after container tag.
     *
     * @param string $value The after container tag.
     */
    public function afterTag(string $value): self
    {
        $new = clone $this;
        $new->afterTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes. The following special options are recognized.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function attributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->attributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified before container attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function beforeAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->beforeAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified before container class.
     *
     * @param string $value The before container class.
     */
    public function beforeClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->beforeAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified before content.
     *
     * @param string|Stringable $value The content.
     */
    public function beforeContent(string|Stringable $value): self
    {
        $new = clone $this;
        $new->beforeContent = (string) $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified before container tag.
     *
     * @param string $value The before container tag.
     */
    public function beforeTag(string $value): self
    {
        $new = clone $this;
        $new->beforeTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified the class `menu` widget.
     *
     * @param string $value The class `menu` widget.
     */
    public function class(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified enable or disable the container widget.
     *
     * @param bool $value The container widget enable or disable, for default is `true`.
     */
    public function container(bool $value): self
    {
        $new = clone $this;
        $new->container = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified the current path.
     *
     * @param string $value The current path.
     */
    public function currentPath(string $value): self
    {
        $new = clone $this;
        $new->currentPath = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified disabled CSS class.
     *
     * @param string $value The CSS class to be appended to the disabled menu item.
     */
    public function disabledClass(string $value): self
    {
        $new = clone $this;
        $new->disabledClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified dropdown container class.
     *
     * @param string $value The dropdown container class.
     */
    public function dropdownContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->dropdownContainerAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified dropdown container tag.
     *
     * @param string $value The dropdown container tag.
     */
    public function dropdownContainerTag(string $value): self
    {
        $new = clone $this;
        $new->dropdownContainerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified dropdown definition widget.
     *
     * @param array $valuesMap The dropdown definition widget.
     */
    public function dropdownDefinitions(array $valuesMap): self
    {
        $new = clone $this;
        $new->dropdownDefinitions = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified first item CSS class.
     *
     * @param string $value The CSS class that will be assigned to the first item in the main menu or each submenu.
     */
    public function firstItemClass(string $value): self
    {
        $new = clone $this;
        $new->firstItemClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified icon container attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function iconContainerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->iconContainerAttributes = $valuesMap;

        return $new;
    }

    /**
     * List of items in the nav widget. Each array element represents a single menu item which can be either a string or
     * an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - active: bool, whether the item should be on active state or not.
     * - disabled: bool, whether the item should be on disabled state or not. For default `disabled` is false.
     * - encode: bool, whether the label should be HTML encoded or not. For default `encodeLabel` is true.
     * - items: array, optional, the item's submenu items. The structure is the same as for `items` option.
     * - itemsContainerAttributes: array, optional, the HTML attributes for the item's submenu container.
     * - link: string, the item's href. Defaults to "#". For default `link` is "#".
     * - linkAttributes: array, the HTML attributes of the item's link. For default `linkAttributes` is `[]`.
     * - icon: string, the item's icon. For default is ``.
     * - iconAttributes: array, the HTML attributes of the item's icon. For default `iconAttributes` is `[]`.
     * - iconClass: string, the item's icon CSS class. For default is ``.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     *
     * @param array $valuesMap the list of items to be rendered.
     */
    public function items(array $valuesMap): self
    {
        $new = clone $this;
        $new->items = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified if enabled or disabled the items' container.
     *
     * @param bool $value The items container enable or disable, for default is `true`.
     */
    public function itemsContainer(bool $value): self
    {
        $new = clone $this;
        $new->itemsContainer = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified items' container attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function itemsContainerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new-> itemsContainerAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified items' container class.
     *
     * @param string $value The CSS class that will be assigned to the items' container.
     */
    public function itemsContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->itemsContainerAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified items tag.
     *
     * @param string $value The tag that will be used to wrap the items.
     */
    public function itemsTag(string $value): self
    {
        $new = clone $this;
        $new->itemsTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified last item CSS class.
     *
     * @param string $value The CSS class that will be assigned to the last item in the main menu or each submenu.
     */
    public function lastItemClass(string $value): self
    {
        $new = clone $this;
        $new->lastItemClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified link attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function linkAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->linkAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified link css class.
     *
     * @param string $value The CSS class that will be assigned to the link.
     */
    public function linkClass(string $value): self
    {
        $new = clone $this;
        $new->linkClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified link tag.
     *
     * @param string $value The tag that will be used to wrap the link.
     */
    public function linkTag(string $value): self
    {
        $new = clone $this;
        $new->linkTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified tag for rendering the menu.
     *
     * @param string $value The tag for rendering the menu.
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified the template used to render the main menu.
     *
     * @param string $value The template used to render the main menu. In this template, the token `{items}` will be
     * replaced.
     */
    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;

        return $new;
    }

    /**
     * Renders the menu.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return string The result of Widget execution to be outputted.
     */
    protected function run(): string
    {
        $items = Helper\Normalizer::menu($this->items, $this->currentPath, $this->activateItems);

        if ($items === []) {
            return '';
        }

        return $this->renderMenu($items);
    }

    private function renderAfterContent(): string
    {
        if ($this->afterTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return PHP_EOL .
            Html::normalTag($this->afterTag, $this->afterContent, $this->afterAttributes)
                ->encode(false)
                ->render();
    }

    private function renderBeforeContent(): string
    {
        if ($this->beforeTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return Html::normalTag($this->beforeTag, $this->beforeContent, $this->beforeAttributes)
            ->encode(false)
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderDropdown(array $items): string
    {
        $dropdownDefinitions = $this->dropdownDefinitions;

        if ($dropdownDefinitions === []) {
            $dropdownDefinitions = [
                'container()' => [false],
                'dividerClass()' => ['dropdown-divider'],
                'toggleAttributes()' => [
                    ['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown', 'role' => 'button'],
                ],
                'toggleType()' => ['link'],
            ];
        }

        $dropdown = Dropdown::widget($dropdownDefinitions)->items($items)->render();

        if ($this->dropdownContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return match ($this->dropdownContainer) {
            true => Html::normalTag($this->dropdownContainerTag, $dropdown, $this->dropdownContainerAttributes)
                ->encode(false)
                ->render(),
            false => $dropdown,
        };
    }

    /**
     * Renders the content of a menu item.
     *
     * Note that the container and the sub-menus are not rendered here.
     *
     * @param array $item The menu item to be rendered. Please refer to {@see items} to see what data might be in the
     * item.
     *
     * @return string The rendering result.
     */
    private function renderItem(array $item): string
    {
        /** @var array */
        $linkAttributes = $item['linkAttributes'] ?? [];
        $linkAttributes = array_merge($linkAttributes, $this->linkAttributes);
        /** @var array */
        $iconContainerAttributes = $item['iconContainerAttributes'] ?? $this->iconContainerAttributes;


        if ($this->linkClass !== '') {
            Html::addCssClass($linkAttributes, $this->linkClass);
        }

        if ($item['active']) {
            $linkAttributes['aria-current'] = 'page';
            Html::addCssClass($linkAttributes, $this->activeClass);
        }

        if ($item['disabled']) {
            Html::addCssClass($linkAttributes, $this->disabledClass);
        }

        if (isset($item['link']) && is_string($item['link'])) {
            $linkAttributes['href'] = $item['link'];
        }

        /**
         * @var string $item['label']
         * @var string $item['icon']
         * @var array $item['iconAttributes']
         * @var string $item['iconClass']
         */
        $label = Helper\Normalizer::renderLabel(
            $item['label'],
            $item['icon'],
            $item['iconAttributes'],
            $item['iconClass'],
            $iconContainerAttributes,
        );

        if ($this->linkTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return match (isset($linkAttributes['href'])) {
            true => Html::normalTag($this->linkTag, $label, $linkAttributes)->encode(false)->render(),
            false => $label,
        };
    }

    /**
     * Recursively renders the menu items (without the container tag).
     *
     * @param array $items The menu items to be rendered recursively.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderItems(array $items): string
    {
        $lines = [];
        $n = count($items);

        /** @psalm-var array[] $items  */
        foreach ($items as $i => $item) {
            if (isset($item['items'])) {
                /** @psalm-var array $item['items'] */
                $lines[] = strtr($this->template, ['{items}' => $this->renderDropdown([$item])]);
            } elseif ($item['visible']) {
                /** @psalm-var array|null $item['itemsContainerAttributes'] */
                $itemsContainerAttributes = array_merge(
                    $this->itemsContainerAttributes,
                    $item['itemsContainerAttributes'] ?? [],
                );

                if ($i === 0 && $this->firstItemClass !== '') {
                    Html::addCssClass($itemsContainerAttributes, $this->firstItemClass);
                }

                if ($i === $n - 1 && $this->lastItemClass !== '') {
                    Html::addCssClass($itemsContainerAttributes, $this->lastItemClass);
                }

                $menu = $this->renderItem($item);

                if ($this->itemsTag === '') {
                    throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
                }

                $lines[] = match ($this->itemsContainer) {
                    false => $menu,
                    default => strtr(
                        $this->template,
                        [
                            '{items}' => Html::normalTag($this->itemsTag, $menu, $itemsContainerAttributes)
                                ->encode(false)
                                ->render(),
                        ],
                    ),
                };
            }
        }

        return PHP_EOL . implode(PHP_EOL, $lines);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderMenu(array $items): string
    {
        $afterContent = '';
        $attributes = $this->attributes;
        $beforeContent = '';

        $content = $this->renderItems($items) . PHP_EOL;

        if ($this->beforeContent !== '') {
            $beforeContent = $this->renderBeforeContent() . PHP_EOL;
        }

        if ($this->afterContent !== '') {
            $afterContent = $this->renderAfterContent();
        }

        if ($this->tagName === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return match ($this->container) {
            false => $beforeContent . trim($content) . $afterContent,
            default => $beforeContent .
                Html::normalTag($this->tagName, $content, $attributes)->encode(false) .
                $afterContent,
        };
    }
}
