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
use Yiisoft\Html\Tag\I;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Widget\Widget;

use function gettype;

final class Dropdown extends Widget
{
    private string $activeClass = 'active';
    private array $attributes = [];
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
     *
     * @return self
     */
    public function activeClass(string $value): self
    {
        $new = clone $this;
        $new->activeClass = $value;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function attributes(array $values): static
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified if the container is enabled, or not. Default is true.
     *
     * @param bool $value The container enabled.
     *
     * @return self
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
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function containerAttributes(array $values): self
    {
        $new = clone $this;
        $new->containerAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified container class.
     *
     * @param string $value The container class.
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function dividerAttributes(array $values): self
    {
        $new = clone $this;
        $new->dividerAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified divider class.
     *
     * @param string $value The divider class.
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
     */
    public function headerTag(string $value): self
    {
        $new = clone $this;
        $new->headerTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item class.
     *
     * @param string $value The item class.
     *
     * @return self
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
     *
     * @return self
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
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function itemContainerAttributes(array $values): self
    {
        $new = clone $this;
        $new->itemContainerAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container class.
     *
     * @param string $value The item container class.
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     * - encodeLabel: bool, whether the label should be HTML encoded or not. For default `encodeLabel` is true.
     * - headerAttributes: array, HTML attributes to be rendered in the item header.
     * - link: string, the item's href. Defaults to "#". For default `link` is "#".
     * - linkAttributes: array, the HTML attributes of the item's link. For default `linkAttributes` is `[]`.
     * - icon: string, the item's icon. For default `icon` is ``.
     * - iconAttributes: array, the HTML attributes of the item's icon. For default `iconAttributes` is `[]`.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - itemsAttributes: array, optional, the HTML attributes for sub-menu.
     *
     * To insert dropdown divider use `-`.
     *
     * @param array $value
     *
     * @return static
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified items container HTML attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function itemsContainerAttributes(array $values): self
    {
        $new = clone $this;
        $new->itemsContainerAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified item container class.
     *
     * @param string $value The item container class.
     *
     * @return self
     */
    public function itemsContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->itemsContainerAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the specified split button attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function splitButtonAttributes(array $values): self
    {
        $new = clone $this;
        $new->splitButtonAttributes = $values;
        return $new;
    }

    /**
     * Returns a new instance with the specified split button class.
     *
     * @param string $value The split button class.
     *
     * @return self
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
     *
     * @return self
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
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function toggleAttributes(array $values): self
    {
        $new = clone $this;
        $new->toggleAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified toggle class.
     *
     * @param string $value The toggle class.
     *
     * @return self
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
     *
     * @return self
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
    protected function run(): string
    {
        $containerAttributes = $this->containerAttributes;
        $items = $this->normalizeItems($this->items);
        $items = $this->renderItems($items) . PHP_EOL;

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

    private function label(array $item): string
    {
        if (!isset($item['label'])) {
            throw new InvalidArgumentException('The "label" option is required.');
        }

        if (!is_string($item['label'])) {
            throw new InvalidArgumentException('The "label" option must be a string.');
        }

        if ($item['label'] === '') {
            throw new InvalidArgumentException('The "label" cannot be an empty string.');
        }

        /** @var bool */
        $encodeLabels = $item['encodeLabel'] ?? true;

        if ($encodeLabels) {
            return htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8', false);
        }

        return $item['label'];
    }

    private function normalizeItems(array $items): array
    {
        /**
         * @psalm-var array[] $items
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        foreach ($items as $i => $child) {
            if (is_array($child)) {
                $items[$i]['label'] = $this->label($child);
                /** @var bool */
                $items[$i]['active'] = $child['active'] ?? false;
                /** @var bool */
                $items[$i]['disabled'] = $child['disabled'] ?? false;
                /** @var bool */
                $items[$i]['enclose'] = $child['enclose'] ?? true;
                /** @var array */
                $items[$i]['headerAttributes'] = $child['headerAttributes'] ?? [];
                /** @var string */
                $items[$i]['link'] = $child['link'] ?? '/';
                /** @var array */
                $items[$i]['linkAttributes'] = $child['linkAttributes'] ?? [];
                /** @var string */
                $items[$i]['icon'] = $child['icon'] ?? '';
                /** @var array */
                $items[$i]['iconAttributes'] = $child['iconAttributes'] ?? [];
                /** @var string */
                $items[$i]['iconClass'] = $child['iconClass'] ?? '';
                /** @var array */
                $items[$i]['iconContainerAttributes'] = $child['iconContainerAttributes'] ?? [];
                /** @var bool */
                $items[$i]['visible'] = $child['visible'] ?? true;
                /** @var array */
                $dropdown = $child['items'] ?? [];
                /** @var array */
                $items[$i]['itemsAttributes'] = $child['itemsAttributes'] ?? [];

                if ($dropdown !== []) {
                    $items[$i]['items'] = $this->normalizeItems($dropdown);
                }
            }
        }

        return $items;
    }

    private function renderDivider(): string
    {
        $dividerAttributes = $this->dividerAttributes;

        if ($this->itemContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        if ($this->dividerClass !== '') {
            Html::addCssClass($dividerAttributes, $this->dividerClass);
        }

        if ($this->dividerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return Html::normalTag(
            $this->itemContainerTag,
            Html::tag($this->dividerTag, '', $dividerAttributes),
            $this->itemContainerAttributes,
        )->encode(false)->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderDropdown(array $items, array $itemsAttributes = []): string
    {
        return self::widget()
            ->attributes($itemsAttributes)
            ->container(false)
            ->dividerAttributes($this->dividerAttributes)
            ->headerClass($this->headerClass)
            ->headerTag($this->headerTag)
            ->itemClass($this->itemClass)
            ->itemContainerAttributes($this->itemContainerAttributes)
            ->itemContainerTag($this->itemContainerTag)
            ->itemTag($this->itemTag)
            ->items($items)
            ->itemsContainerAttributes($this->itemsContainerAttributes)
            ->toggleAttributes($this->toggleAttributes)
            ->toggleType($this->toggleType)
            ->render();
    }

    private function renderHeader(string $label, array $headerAttributes = []): string
    {
        if ($this->headerClass !== '') {
            Html::addCssClass($headerAttributes, $this->headerClass);
        }

        if ($this->itemContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return Html::normalTag(
            $this->itemContainerTag,
            Html::normalTag($this->headerTag, $label, $headerAttributes),
            $this->itemContainerAttributes,
        )->encode(false)->render();
    }

    /**
     * @param array $item The item to be rendered.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderItem(array $item): string
    {
        /** @var bool */
        $enclose = $item['enclose'] ?? true;
        /** @var array */
        $headerAttributes = $item['headerAttributes'];
        /** @var array */
        $items = $item['items'] ?? [];
        /** @var array */
        $itemsAttributes = $item['itemsAttributes'] ?? [];
        /**
         * @var string $item['label']
         * @var string $item['icon']
         * @var string $item['iconClass']
         * @var array $item['iconAttributes']
         * @var array $item['iconContainerAttributes']
         */
        $label = $this->renderLabel(
            $item['label'],
            $item['icon'],
            $item['iconClass'],
            $item['iconAttributes'],
            $item['iconContainerAttributes'],
        );
        /** @var array */
        $lines = [];
        /** @var string */
        $link = $item['link'];
        /** @var array */
        $linkAttributes = $item['linkAttributes'];
        /** @var array */
        $toggleAttributes = $item['toggleAttributes'] ?? [];

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

        if ($items === []) {
            $lines[] = $this->renderItemContent($label, $link, $enclose, $linkAttributes, $headerAttributes);
        } else {
            $itemContainer = $this->renderItemContainer($items, $itemsAttributes);
            $toggle = $this->renderToggle($label, $link, $toggleAttributes);
            $toggleSplitButton = $this->renderToggleSplitButton($label);

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

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderItemContainer(array $items, array $itemsContainerAttributes = []): string
    {
        if ($itemsContainerAttributes === []) {
            $itemsContainerAttributes = $this->itemsContainerAttributes;
        }

        if (isset($this->attributes['id'])) {
            $itemsContainerAttributes['aria-labelledby'] = $this->attributes['id'];
        }

        if ($this->itemsContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return Html::normalTag(
            $this->itemsContainerTag,
            $this->renderDropdown($items, $itemsContainerAttributes),
            $itemsContainerAttributes,
        )->encode(false)->render();
    }

    private function renderItemContent(
        string $label,
        string $link,
        bool $enclose,
        array $linkAttributes = [],
        array $headerAttributes = []
    ): string {
        return match (true) {
            $label === '-' => $this->renderDivider(),
            $enclose === false => $label,
            $link === '' => $this->renderHeader($label, $headerAttributes),
            default => $this->renderItemLink($label, $link, $linkAttributes),
        };
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderItems(array $items = []): string
    {
        $lines = [];

        /** @var array|string $item */
        foreach ($items as $item) {
            $lines[] = match (gettype($item)) {
                'array' => $this->renderItem($item),
                'string' => $this->renderDivider(),
            };
        }

        return PHP_EOL . implode(PHP_EOL, $lines);
    }

    private function renderLabel(
        string $label,
        string $icon,
        string $iconClass,
        array $iconAttributes = [],
        array $iconContainerAttributes = []
    ): string {
        $html = '';

        if ($iconClass !== '') {
            Html::addCssClass($iconAttributes, $iconClass);
        }

        if ($icon !== '' || $iconClass !== '') {
            $i = I::tag()->addAttributes($iconAttributes)->content($icon)->encode(false)->render();
            $html = Span::tag()->addAttributes($iconContainerAttributes)->content($i)->encode(false)->render();
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }

    private function renderItemLink(
        string $label,
        string $link,
        array $linkAttributes = []
    ): string {
        $itemContainerAttributes = $this->itemContainerAttributes;
        $linkAttributes['href'] = $link;

        if ($this->itemTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        $a = Html::normalTag($this->itemTag, $label, $linkAttributes)->encode(false);

        if ($this->itemContainerTag === '') {
            throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
        }

        return match ($this->itemContainer) {
            true => Html::normalTag($this->itemContainerTag, $a, $itemContainerAttributes)->encode(false)->render(),
            default => $a->render(),
        };
    }

    private function renderToggle(string $label, string $link, array $toggleAttributes = []): string
    {
        if ($toggleAttributes === []) {
            $toggleAttributes = $this->toggleAttributes;
        }

        if (isset($this->attributes['id'])) {
            $toggleAttributes['id'] = $this->attributes['id'];
        }

        return match ($this->toggleType) {
            'link' => $this->renderToggleLink($label, $link, $toggleAttributes),
            'split' => $this->renderToggleSplit($label, $toggleAttributes),
            default => $this->renderToggleButton($label, $toggleAttributes),
        };
    }

    private function renderToggleButton(string $label, array $toggleAttributes = []): string
    {
        return Button::tag()->addAttributes($toggleAttributes)->content($label)->render();
    }

    private function renderToggleLink(string $label, string $link, array $toggleAttributes = []): string
    {
        return A::tag()->addAttributes($toggleAttributes)->content($label)->href($link)->render();
    }

    private function renderToggleSplit(string $label, array $toggleAttributes = []): string
    {
        return Button::tag()
            ->addAttributes($toggleAttributes)
            ->content(Span::tag()->addAttributes($this->splitButtonSpanAttributes)->content($label))
            ->render();
    }

    private function renderToggleSplitButton(string $label): string
    {
        return Button::tag()->addAttributes($this->splitButtonAttributes)->content($label)->render();
    }
}
