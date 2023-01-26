<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Widget\Widget;

use function array_merge;
use function gettype;
use function implode;
use function str_contains;
use function trim;

final class Dropdown extends Widget
{
    private string $activeClass = 'active';
    private bool $container = true;
    private array $containerAttributes = [];
    private string $containerClass = '';
    private string $containerTag = 'div';
    private string $disabledClass = 'disabled';
    private array $dividerAttributes = [];
    private string $dividerClass = 'dropdown-divider';
    private string $dividerTag = 'hr';
    private string $headerClass = '';
    private string $headerTag = 'span';
    private string $id = '';
    private string $itemClass = '';
    private string $itemTag = 'a';
    private bool $itemContainer = true;
    private array $itemContainerAttributes = [];
    private string $itemContainerTag = 'li';
    private array $items = [];
    private array $itemsContainerAttributes = [];
    private string $itemsContainerTag = 'ul';
    private array $splitButtonAttributes = [];
    private array $splitButtonSpanAttributes = [];
    private array $toggleAttributes = [];
    private string $toggleType = 'button';

    /**
     * Returns a new instance with the specified active class.
     *
     * @param string $value The active class.
     */
    public function activeClass(string $value): self
    {
        $new = clone $this;
        $new->activeClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified if the container is enabled, or not. Default is true.
     *
     * @param bool $value The container enabled.
     */
    public function container(bool $value): self
    {
        $new = clone $this;
        $new->container = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified container HTML attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function containerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->containerAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified container class.
     *
     * @param string $value The container class.
     */
    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified container tag.
     *
     * @param string $value The container tag.
     */
    public function containerTag(string $value): self
    {
        $new = clone $this;
        $new->containerTag = $value;
        return $new;
    }

    /**
     * Returns a new instance with the specified disabled class.
     *
     * @param string $value The disabled class.
     */
    public function disabledClass(string $value): self
    {
        $new = clone $this;
        $new->disabledClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified divider HTML attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function dividerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->dividerAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified divider class.
     *
     * @param string $value The divider class.
     */
    public function dividerClass(string $value): self
    {
        $new = clone $this;
        $new->dividerClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified divider tag.
     *
     * @param string $value The divider tag.
     */
    public function dividerTag(string $value): self
    {
        $new = clone $this;
        $new->dividerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified header class.
     *
     * @param string $value The header class.
     */
    public function headerClass(string $value): self
    {
        $new = clone $this;
        $new->headerClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified header tag.
     *
     * @param string $value The header tag.
     */
    public function headerTag(string $value): self
    {
        $new = clone $this;
        $new->headerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified Widget ID.
     *
     * @param string $value The id of the widget.
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item class.
     *
     * @param string $value The item class.
     */
    public function itemClass(string $value): self
    {
        $new = clone $this;
        $new->itemClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container, if false, the item container will not be rendered.
     *
     * @param bool $value The item container.
     */
    public function itemContainer(bool $value): self
    {
        $new = clone $this;
        $new->itemContainer = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container HTML attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function itemContainerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->itemContainerAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container class.
     *
     * @param string $value The item container class.
     */
    public function itemContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->itemContainerAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified item container tag.
     *
     * @param string $value The item container tag.
     */
    public function itemContainerTag(string $value): self
    {
        $new = clone $this;
        $new->itemContainerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item tag.
     *
     * @param string $value The item tag.
     */
    public function itemTag(string $value): self
    {
        $new = clone $this;
        $new->itemTag = $value;

        return $new;
    }

    /**
     * List of menu items in the dropdown. Each array element can be either an HTML string, or an array representing a
     * single menu with the following structure:
     *
     * - label: string, required, the nav item label.
     * - active: bool, whether the item should be on active state or not.
     * - disabled: bool, whether the item should be on disabled state or not. For default `disabled` is false.
     * - enclose: bool, whether the item should be enclosed by a `<li>` tag or not. For default `enclose` is true.
     * - encode: bool, whether the label should be HTML encoded or not. For default `encodeLabel` is true.
     * - headerAttributes: array, HTML attributes to be rendered in the item header.
     * - link: string, the item's href. Defaults to "#". For default `link` is "#".
     * - linkAttributes: array, the HTML attributes of the item's link. For default `linkAttributes` is `[]`.
     * - icon: string, the item's icon. For default `icon` is ``.
     * - iconAttributes: array, the HTML attributes of the item's icon. For default `iconAttributes` is `[]`.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - itemsContainerAttributes: array, optional, the HTML attributes for tag `<li>`.
     *
     * To insert dropdown divider use `-`.
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified items' container HTML attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function itemsContainerAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->itemsContainerAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container class.
     *
     * @param string $value The item container class.
     */
    public function itemsContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->itemsContainerAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified items' container tag.
     *
     * @param string $value The items' container tag.
     */
    public function itemsContainerTag(string $value): self
    {
        $new = clone $this;
        $new->itemsContainerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified split button attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function splitButtonAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->splitButtonAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified split button class.
     *
     * @param string $value The split button class.
     */
    public function splitButtonClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->splitButtonAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified split button span class.
     *
     * @param string $value The split button span class.
     */
    public function splitButtonSpanClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->splitButtonSpanAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified toggle HTML attributes.
     *
     * @param array $valuesMap Attribute values indexed by attribute names.
     */
    public function toggleAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->toggleAttributes = $valuesMap;

        return $new;
    }

    /**
     * Returns a new instance with the specified toggle class.
     *
     * @param string $value The toggle class.
     */
    public function toggleClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->toggleAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified toggle type, if `button` the toggle will be a button, otherwise a
     * `a` tag will be used.
     *
     * @param string $value The toggle tag.
     */
    public function toggleType(string $value): self
    {
        $new = clone $this;
        $new->toggleType = $value;

        return $new;
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function render(): string
    {
        /**
         * @psalm-var array<
         *   array-key,
         *   array{
         *     label: string,
         *     link: string,
         *     linkAttributes: array,
         *     items?: array,
         *     active: bool,
         *     disabled: bool,
         *     enclose: bool,
         *     headerAttributes: array,
         *     itemContainerAttributes: array,
         *     toggleAttributes: array,
         *     visible: bool,
         *     items: array,
         *   }|string
         * > $normalizedItems
         */
        $normalizedItems = Helper\Normalizer::dropdown($this->items);

        $containerAttributes = $this->containerAttributes;

        $items = $this->renderItems($normalizedItems) . PHP_EOL;

        if (trim($items) === '') {
            return '';
        }

        if ($this->containerClass !== '') {
            Html::addCssClass($containerAttributes, $this->containerClass);
        }

        if ($this->containerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return match ($this->container) {
            true => Html::normalTag($this->containerTag, $items, $containerAttributes)->encode(false)->render(),
            false => $items,
        };
    }

    private function renderDivider(): string
    {
        $dividerAttributes = $this->dividerAttributes;

        if ($this->dividerClass !== '') {
            Html::addCssClass($dividerAttributes, $this->dividerClass);
        }

        if ($this->dividerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return $this->renderItemContainer(
            Html::tag($this->dividerTag, '', $dividerAttributes)->encode(false)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderDropdown(array $items): string
    {
        return self::widget()
            ->container(false)
            ->dividerAttributes($this->dividerAttributes)
            ->headerClass($this->headerClass)
            ->headerTag($this->headerTag)
            ->itemClass($this->itemClass)
            ->itemContainerAttributes($this->itemContainerAttributes)
            ->itemContainerTag($this->itemContainerTag)
            ->items($items)
            ->itemsContainerAttributes(array_merge($this->itemsContainerAttributes))
            ->itemTag($this->itemTag)
            ->toggleAttributes($this->toggleAttributes)
            ->toggleType($this->toggleType)
            ->render();
    }

    private function renderHeader(string $label, array $headerAttributes = []): string
    {
        if ($this->headerClass !== '') {
            Html::addCssClass($headerAttributes, $this->headerClass);
        }

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return $this->renderItemContainer(
            Html::normalTag($this->headerTag, $label, $headerAttributes)->encode(false)->render(),
        );
    }

    /**
     * @param array $item The item to be rendered.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @psalm-param array{
     *   label: string,
     *   link: string,
     *   linkAttributes: array,
     *   active: bool,
     *   disabled: bool,
     *   enclose: bool,
     *   headerAttributes: array,
     *   itemContainerAttributes: array,
     *   toggleAttributes: array,
     *   visible: bool,
     *   items: array,
     * } $item
     */
    private function renderItem(array $item): string
    {
        if ($item['visible'] === false) {
            return '';
        }

        $lines = [];
        $linkAttributes = $item['linkAttributes'];

        if ($this->itemClass !== '') {
            Html::addCssClass($linkAttributes, $this->itemClass);
        }

        if ($item['active']) {
            $linkAttributes['aria-current'] = 'true';
            Html::addCssClass($linkAttributes, [$this->activeClass]);
        }

        if ($item['disabled']) {
            Html::addCssClass($linkAttributes, $this->disabledClass);
        }

        if ($item['items'] === []) {
            $lines[] = $this->renderItemContent(
                $item['label'],
                $item['link'],
                $item['enclose'],
                $linkAttributes,
                $item['headerAttributes'],
                $item['itemContainerAttributes'],
            );
        } else {
            $itemContainer = $this->renderItemsContainer($this->renderDropdown($item['items']));
            $toggle = $this->renderToggle($item['label'], $item['link'], $item['toggleAttributes']);
            $toggleSplitButton = $this->renderToggleSplitButton($item['label']);

            if ($this->toggleType === 'split' && !str_contains($this->containerClass, 'dropstart')) {
                $lines[] = $toggleSplitButton . PHP_EOL . $toggle . PHP_EOL . $itemContainer;
            } elseif ($this->toggleType === 'split' && str_contains($this->containerClass, 'dropstart')) {
                $lines[] = $toggle . PHP_EOL . $itemContainer . PHP_EOL . $toggleSplitButton;
            } else {
                $lines[] = $toggle . PHP_EOL . $itemContainer;
            }
        }

        /** @psalm-var string[] $lines */
        return implode(PHP_EOL, $lines);
    }

    private function renderItemContainer(string $content, array $itemContainerAttributes = []): string
    {
        if ($this->itemContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        if ($itemContainerAttributes === []) {
            $itemContainerAttributes = $this->itemContainerAttributes;
        }

        return Html::normalTag($this->itemContainerTag, $content, $itemContainerAttributes)
            ->encode(false)
            ->render();
    }

    private function renderItemsContainer(string $content): string
    {
        $itemsContainerAttributes = $this->itemsContainerAttributes;

        if ($this->id !== '') {
            $itemsContainerAttributes['aria-labelledby'] = $this->id;
        }

        if ($this->itemsContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return Html::normalTag($this->itemsContainerTag, $content, $itemsContainerAttributes)
            ->encode(false)
            ->render();
    }

    private function renderItemContent(
        string $label,
        string $link,
        bool $enclose,
        array $linkAttributes = [],
        array $headerAttributes = [],
        array $itemContainerAttributes = [],
    ): string {
        return match (true) {
            $label === '-' => $this->renderDivider(),
            $enclose === false => $label,
            $link === '' => $this->renderHeader($label, $headerAttributes),
            default => $this->renderItemLink($label, $link, $linkAttributes, $itemContainerAttributes),
        };
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @psalm-param array<
     *   array-key,
     *   array{
     *     label: string,
     *     link: string,
     *     linkAttributes: array,
     *     active: bool,
     *     disabled: bool,
     *     enclose: bool,
     *     headerAttributes: array,
     *     itemContainerAttributes: array,
     *     toggleAttributes: array,
     *     visible: bool,
     *     items: array,
     *   }|string
     * > $items
     */
    private function renderItems(array $items = []): string
    {
        $lines = [];

        foreach ($items as $item) {
            $line = match (gettype($item)) {
                'array' => $this->renderItem($item),
                'string' => $this->renderDivider(),
            };

            if ($line !== '') {
                $lines[] = $line;
            }
        }

        return PHP_EOL . implode(PHP_EOL, $lines);
    }

    private function renderItemLink(
        string $label,
        string $link,
        array $linkAttributes = [],
        array $itemContainerAttributes = []
    ): string {
        $linkAttributes['href'] = $link;

        if ($this->itemTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        $linkTag = Html::normalTag($this->itemTag, $label, $linkAttributes)->encode(false)->render();

        return match ($this->itemContainer) {
            true => $this->renderItemContainer($linkTag, $itemContainerAttributes),
            default => $linkTag,
        };
    }

    private function renderToggle(string $label, string $link, array $toggleAttributes = []): string
    {
        if ($toggleAttributes === []) {
            $toggleAttributes = $this->toggleAttributes;
        }

        if ($this->id !== '') {
            $toggleAttributes['id'] = $this->id;
        }

        return match ($this->toggleType) {
            'link' => $this->renderToggleLink($label, $link, $toggleAttributes),
            'split' => $this->renderToggleSplit($label, $toggleAttributes),
            default => $this->renderToggleButton($label, $toggleAttributes),
        };
    }

    private function renderToggleButton(string $label, array $toggleAttributes = []): string
    {
        return Button::tag()->attributes($toggleAttributes)->content($label)->type('button')->render();
    }

    private function renderToggleLink(string $label, string $link, array $toggleAttributes = []): string
    {
        return A::tag()->attributes($toggleAttributes)->content($label)->href($link)->render();
    }

    private function renderToggleSplit(string $label, array $toggleAttributes = []): string
    {
        return Button::tag()
            ->attributes($toggleAttributes)
            ->content(Span::tag()->attributes($this->splitButtonSpanAttributes)->content($label))
            ->type('button')
            ->render();
    }

    private function renderToggleSplitButton(string $label): string
    {
        return Button::tag()->attributes($this->splitButtonAttributes)->content($label)->type('button')->render();
    }
}
