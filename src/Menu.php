<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use function array_merge;
use function array_values;
use function call_user_func;
use Closure;
use function count;

use function implode;
use JsonException;
use function strtr;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

/**
 * Menu displays a multi-level menu using nested HTML lists.
 *
 * The main property of Menu is {@see items}, which specifies the possible items in the menu. A menu item can contain
 * sub-items which specify the sub-menu under that menu item.
 *
 * Menu checks the current route and request parameters to toggle certain menu items with active state.
 *
 * Note that Menu only renders the HTML tags about the menu. It does not do any styling. You are responsible to provide
 * CSS styles to make it look like a real menu.
 *
 * The following example shows how to use Menu:
 *
 * ```php
 * echo Menu::Widget()
 *     ->items([
 *         ['label' => 'Login', 'url' => 'site/login', 'visible' => true],
 *     ]);
 * ```
 */
final class Menu extends Widget
{
    /**
     * @var string the template used to render a list of sub-menus.
     *
     * In this template, the token `{items}` will be replaced with the rendered sub-menu items.
     */
    private string $submenuTemplate = "\n<ul>\n{items}\n</ul>\n";
    private array $items = [];
    private array $itemOptions = [];
    private string $linkTemplate = '<a href="{url}">{label}</a>';
    private string $labelTemplate = '{label}';
    private bool $encodeLabels = true;
    private string $activeCssClass = 'active';
    private bool $activateItems = true;
    private bool $activateParents = false;
    private ?string $currentPath = null;
    private bool $hideEmptyItems = true;
    private array $options = [];
    private ?string $firstItemCssClass = null;
    private ?string $lastItemCssClass = null;

    /**
     * Renders the menu.
     *
     * @throws JsonException
     *
     * @return string the result of Widget execution to be outputted.
     */
    protected function run(): string
    {
        $items = $this->normalizeItems($this->items, $hasActiveChild);

        if (empty($items)) {
            return '';
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');

        return empty($tag)
            ? $this->renderItems($items)
            : Html::tag($tag, $this->renderItems($items), $options)->encode(false)->render()
        ;
    }

    /**
     * @param bool $value whether to automatically activate items according to whether their route setting matches the
     * currently requested route.
     *
     * @return $this
     */
    public function activateItems(bool $value): self
    {
        $this->activateItems = $value;

        return $this;
    }

    /**
     * @param bool $value whether to activate parent menu items when one of the corresponding child menu items is
     * active. The activated parent menu items will also have its CSS classes appended with {@see activeCssClass}.
     *
     * @return $this
     */
    public function activateParents(bool $value): self
    {
        $this->activateParents = $value;

        return $this;
    }

    /**
     * @param string $value the CSS class to be appended to the active menu item.
     *
     * @return $this
     */
    public function activeCssClass(string $value): self
    {
        $this->activeCssClass = $value;

        return $this;
    }

    /**
     * @param string|null $value allows you to assign the current path of the url from request controller.
     *
     * @return $this
     */
    public function currentPath(?string $value): self
    {
        $this->currentPath = $value;

        return $this;
    }

    /**
     * @param bool $value whether the labels for menu items should be HTML-encoded.
     *
     * @return $this
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * @param string|null $value the CSS class that will be assigned to the first item in the main menu or each submenu.
     * Defaults to null, meaning no such CSS class will be assigned.
     *
     * @return $this
     */
    public function firstItemCssClass(?string $value): self
    {
        $this->firstItemCssClass = $value;

        return $this;
    }

    /**
     * @param bool $value whether to hide empty menu items. An empty menu item is one whose `url` option is not set and
     * which has no visible child menu items.
     *
     * @return $this
     */
    public function hideEmptyItems(bool $value): self
    {
        $this->hideEmptyItems = $value;

        return $this;
    }

    /**
     * @param array $value list of menu items. Each menu item should be an array of the following structure:
     *
     * - label: string, optional, specifies the menu item label. When {@see encodeLabels} is true, the label will be
     *   HTML-encoded. If the label is not specified, an empty string will be used.
     * - encode: bool, optional, whether this item`s label should be HTML-encoded. This param will override global
     *   {@see encodeLabels} param.
     * - url: string or array, optional, specifies the URL of the menu item. When this is set, the actual menu item
     *   content will be generated using {@see linkTemplate}; otherwise, {@see labelTemplate} will be used.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - items: array, optional, specifies the sub-menu items. Its format is the same as the parent items.
     * - active: bool or Closure, optional, whether this menu item is in active state (currently selected). When
     *   using a closure, its signature should be `function ($item, $hasActiveChild, $isItemActive, $Widget)`. Closure
     *   must return `true` if item should be marked as `active`, otherwise - `false`. If a menu item is active, its CSS
     *   class will be appended with {@see activeCssClass}. If this option is not set, the menu item will be set active
     *   automatically when the current request is triggered by `url`. For more details, please refer to
     *   {@see isItemActive()}.
     * - template: string, optional, the template used to render the content of this menu item. The token `{url}` will
     *   be replaced by the URL associated with this menu item, and the token `{label}` will be replaced by the label
     *   of the menu item. If this option is not set, {@see linkTemplate} or {@see labelTemplate} will be used instead.
     * - submenuTemplate: string, optional, the template used to render the list of sub-menus. The token `{items}` will
     *   be replaced with the rendered sub-menu items. If this option is not set, {@see submenuTemplate} will be used
     *   instead.
     * - options: array, optional, the HTML attributes for the menu container tag.
     *
     * @return $this
     */
    public function items(array $value): self
    {
        $this->items = $value;

        return $this;
    }

    /**
     * @param array $value list of HTML attributes shared by all menu {@see items}. If any individual menu item
     * specifies its `options`, it will be merged with this property before being used to generate the HTML attributes
     * for the menu item tag. The following special options are recognized:
     *
     * - tag: string, defaults to "li", the tag name of the item container tags. Set to false to disable container tag.
     *   See also {@see \Yiisoft\Html\Html::tag()}
     *
     * @return $this
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes() for details on how attributes are being rendered}
     */
    public function itemOptions(array $value): self
    {
        $this->itemOptions = $value;

        return $this;
    }

    /**
     * @param string $value the template used to render the body of a menu which is NOT a link.
     *
     * In this template, the token `{label}` will be replaced with the label of the menu item.
     *
     * This property will be overridden by the `template` option set in individual menu items via {@see items}.
     *
     * @return $this
     */
    public function labelTemplate(string $value): self
    {
        $this->labelTemplate = $value;

        return $this;
    }

    /**
     * @param string|null $value the CSS class that will be assigned to the last item in the main menu or each submenu.
     * Defaults to null, meaning no such CSS class will be assigned.
     *
     * @return $this
     */
    public function lastItemCssClass(?string $value): self
    {
        $this->lastItemCssClass = $value;

        return $this;
    }

    /**
     * @param string $value the template used to render the body of a menu which is a link. In this template, the token
     * `{url}` will be replaced with the corresponding link URL; while `{label}` will be replaced with the link text.
     *
     * This property will be overridden by the `template` option set in individual menu items via {@see items}.
     *
     * @return $this
     */
    public function linkTemplate(string $value): self
    {
        $this->linkTemplate = $value;

        return $this;
    }

    /**
     * @param array $value the HTML attributes for the menu's container tag. The following special options are
     * recognized:
     *
     * - tag: string, defaults to "ul", the tag name of the item container tags. Set to false to disable container tag.
     *   See also {@see \Yiisoft\Html\Html::tag()}.
     *
     * @return $this
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * Recursively renders the menu items (without the container tag).
     *
     * @param array $items the menu items to be rendered recursively
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderItems(array $items): string
    {
        $n = count($items);
        $lines = [];

        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];

            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }

            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }

            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);

            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }

            $lines[] = empty($tag) ? $menu : Html::tag($tag, $menu, $options)->encode(false);
        }

        return implode("\n", $lines);
    }

    /**
     * Renders the content of a menu item.
     *
     * Note that the container and the sub-menus are not rendered here.
     *
     * @param array $item the menu item to be rendered. Please refer to {@see items} to see what data might be in the
     * item.
     *
     * @return string the rendering result
     */
    protected function renderItem(array $item): string
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode($item['url']),
                '{label}' => $item['label'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    /**
     * Normalizes the {@see items} property to remove invisible items and activate certain items.
     *
     * @param array $items  the items to be normalized.
     * @param bool|null $active whether there is an active child menu item.
     *
     * @return array the normalized menu items
     */
    protected function normalizeItems(array $items, ?bool &$active): array
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }

            if (!isset($item['label'])) {
                $item['label'] = '';
            }

            $encodeLabel = $item['encode'] ?? $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;

            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }

            if (!isset($item['active'])) {
                if (
                    ($this->activateParents && $hasActiveChild)
                    || ($this->activateItems && $this->isItemActive($item))
                ) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof Closure) {
                $active = $items[$i]['active'] = call_user_func(
                    $item['active'],
                    $item,
                    $hasActiveChild,
                    $this->isItemActive($item),
                    $this
                );
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking match that specified in the `url` option of the menu item.
     *
     * Only when 'url' match $_SERVER['REQUEST_URI'] respectively, will a menu item be considered active.
     *
     * @param array $item the menu item to be checked
     * @param bool $active returns the result when the item is active
     *
     * @return bool whether the menu item is active
     */
    protected function isItemActive(array $item, bool $active = false): bool
    {
        if (
            $this->activateItems
            && $this->currentPath !== '/'
            && isset($item['url'])
            && $item['url'] === $this->currentPath
        ) {
            $active = true;
        }

        return $active;
    }
}
