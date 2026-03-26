<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_key_exists;
use function implode;
use function is_array;
use function is_string;
use function json_encode;
use function strtr;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;
use const PHP_EOL;

/**
 * Breadcrumbs displays a list of items indicating the position of the current page in the whole site hierarchy.
 *
 * For example, breadcrumbs like "Home / Sample Post / Edit" means the user is viewing an edit page for the
 * "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home" to return to the homepage.
 *
 * To use Breadcrumbs, you need to configure its {@see Breadcrumbs::items()} method,
 * which specifies the items to be displayed. For example:
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget()
 *     -> itemTemplate() => "<li><i>{link}</i></li>\n", // template for all links
 *     -> items() => [
 *         [
 *             'label' => 'Post Category',
 *             'url' => 'post-category/view?id=10',
 *             'template' => "<li><b>{link}</b></li>\n", // template for this link only
 *         ],
 *         ['label' => 'Sample Post', 'url' => 'post/edit?id=1'],
 *         'Edit',
 *     ];
 * ```
 *
 * Because breadcrumbs usually appears in nearly every page of a website, you may consider placing it in a layout view.
 * You can use a view common parameter (e.g. `$this->getCommonParameter('breadcrumbs')`) to configure the items in
 * different views. In the layout view, you assign this view parameter to the {@see Breadcrumbs::items()} method
 * like the following:
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget()->items($this->getCommonParameter('breadcrumbs', []));
 * ```
 */
final class Breadcrumbs extends Widget
{
    private string $activeItemTemplate = "<li class=\"active\">{link}</li>\n";
    private array $attributes = ['class' => 'breadcrumb'];
    private bool $container = false;
    private array $containerAttributes = [];
    private string $containerClass = '';
    private string $containerTag = 'nav';
    private ?array $homeItem = ['label' => 'Home', 'url' => '/'];
    private array $items = [];
    private string $itemTemplate = "<li>{link}</li>\n";
    private bool $jsonLd = false;
    private string $tag = 'ul';

    /**
     * Returns a new instance with the specified active item template.
     *
     * @param string $value The template used to render each active item in the breadcrumbs.
     * The token `{link}` will be replaced with the actual HTML link for each active item.
     */
    public function activeItemTemplate(string $value): self
    {
        $new = clone $this;
        $new->activeItemTemplate = $value;

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
     * Returns a new instance with the specified if the container is enabled, or not. Default is false.
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
     * Returns a new instance with the specified first item in the breadcrumbs (called home link).
     *
     * If a null is specified, the home item will not be rendered.
     *
     * @param array|null $value Please refer to {@see items()} on the format.
     *
     * @throws InvalidArgumentException If an empty array is specified.
     */
    public function homeItem(?array $value): self
    {
        if ($value === []) {
            throw new InvalidArgumentException(
                'The home item cannot be an empty array. To disable rendering of the home item, specify null.',
            );
        }

        $new = clone $this;
        $new->homeItem = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified Widget ID.
     *
     * @param string|null $value The id of the widget.
     *
     * @psalm-param non-empty-string|null $value
     */
    public function id(?string $value): self
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if ($value === '') {
            throw new InvalidArgumentException('The id cannot be an empty string.');
        }

        $new = clone $this;
        $new->attributes['id'] = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified list of items.
     *
     * @param array $value List of items to appear in the breadcrumbs. If this property is empty, the widget will not
     * render anything. Each array element represents a single item in the breadcrumbs with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the item',  // required
     *     'url' => 'url of the item',      // optional
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     * If an item is active, you only need to specify its "label", and instead of writing `['label' => $label]`, you may
     * simply use `$label`.
     *
     * Additional array elements for each item will be treated as the HTML attributes for the hyperlink tag.
     * For example, the following item specification will generate a hyperlink with CSS class `external`:
     *
     * ```php
     * [
     *     'label' => 'demo',
     *     'url' => 'http://example.com',
     *     'class' => 'external',
     * ]
     * ```
     *
     * To disable encode for a specific item, you can set the encode option to false:
     *
     * ```php
     * [
     *     'label' => '<strong>Hello!</strong>',
     *     'encode' => false,
     * ]
     * ```
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified item template.
     *
     * @param string $value The template used to render each inactive item in the breadcrumbs.
     * The token `{link}` will be replaced with the actual HTML link for each inactive item.
     */
    public function itemTemplate(string $value): self
    {
        $new = clone $this;
        $new->itemTemplate = $value;

        return $new;
    }

    /**
     * Returns a new instance with JSON-LD structured data rendering enabled or disabled.
     *
     * When enabled, a `<script type="application/ld+json">` block with BreadcrumbList structured data
     * is appended to the widget output.
     *
     * @param bool $value Whether to render JSON-LD structured data.
     *
     * @link https://schema.org/BreadcrumbList
     */
    public function jsonLd(bool $value): self
    {
        $new = clone $this;
        $new->jsonLd = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified tag.
     *
     * @param string $value The tag name.
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;

        return $new;
    }

    /**
     * Renders the widget.
     *
     * @return string The result of widget execution to be outputted.
     */
    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        $items = [];

        if ($this->homeItem !== null) {
            $items[] = $this->renderItem($this->homeItem, $this->itemTemplate);
        }

        foreach ($this->items as $item) {
            if (!is_array($item)) {
                $item = ['label' => $item];
            }

            if ($item !== []) {
                $items[] = $this->renderItem(
                    $item,
                    isset($item['url']) ? $this->itemTemplate : $this->activeItemTemplate,
                );
            }
        }

        $body = implode('', $items);

        $result = empty($this->tag)
            ? $body
            : Html::normalTag($this->tag, PHP_EOL . $body, $this->attributes)->encode(false)->render();

        if ($this->container) {
            if ($this->containerTag === '') {
                throw new InvalidArgumentException('Tag name must be a string and cannot be empty.');
            }

            $containerAttributes = $this->containerAttributes;

            if ($this->containerClass !== '') {
                Html::addCssClass($containerAttributes, $this->containerClass);
            }

            $result = Html::normalTag($this->containerTag, PHP_EOL . $result . PHP_EOL, $containerAttributes)
                ->encode(false)
                ->render();
        }

        if ($this->jsonLd) {
            $result .= PHP_EOL . $this->renderJsonLd();
        }

        return $result;
    }

    /**
     * Renders JSON-LD structured data for the breadcrumbs.
     *
     * @return string The `<script type="application/ld+json">` block with BreadcrumbList structured data.
     */
    public function renderJsonLd(): string
    {
        $listElements = [];
        $position = 1;

        if ($this->homeItem !== null) {
            $element = $this->buildJsonLdItem($this->homeItem, $position);
            if ($element !== null) {
                $listElements[] = $element;
                $position++;
            }
        }

        foreach ($this->items as $item) {
            if (!is_array($item)) {
                $item = ['label' => $item];
            }

            if ($item === []) {
                continue;
            }

            $element = $this->buildJsonLdItem($item, $position);
            if ($element !== null) {
                $listElements[] = $element;
                $position++;
            }
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listElements,
        ];

        $json = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * Builds a single JSON-LD ListItem element.
     *
     * @return array|null The ListItem data, or null if the item has no label.
     */
    private function buildJsonLdItem(array $item, int $position): ?array
    {
        if (!isset($item['label']) || !is_string($item['label'])) {
            return null;
        }

        $element = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $item['label'],
        ];

        if (isset($item['url']) && is_string($item['url'])) {
            $element['item'] = $item['url'];
        }

        return $element;
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $item The item to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template The template to be used to render the link. The token "{link}" will be replaced by the
     * link.
     *
     * @throws InvalidArgumentException if `$item` does not have "label" element.
     *
     * @return string The rendering result.
     */
    private function renderItem(array $item, string $template): string
    {
        if (!array_key_exists('label', $item)) {
            throw new InvalidArgumentException('The "label" element is required for each item.');
        }

        if (!is_string($item['label'])) {
            throw new InvalidArgumentException('The "label" element must be a string.');
        }

        /** @var bool $encodeLabel */
        $encodeLabel = $item['encode'] ?? true;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

        if (isset($item['template']) && is_string($item['template'])) {
            $template = $item['template'];
        }

        if (isset($item['url']) && is_string($item['url'])) {
            $link = $item['url'];
            unset($item['template'], $item['label'], $item['url']);
            $link = Html::a($label, $link, $item);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }
}
