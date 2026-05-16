<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;
use Yiisoft\View\ViewInterface;

use function array_key_exists;
use function implode;
use function is_array;
use function is_string;
use function strtr;

use const PHP_EOL;

/**
 * Breadcrumbs displays a list of items indicating the position of the current page in the site hierarchy.
 *
 * For example, breadcrumbs like "Home / Sample Post / Edit" mean the user is viewing an edit page for the
 * "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home" to return to the homepage.
 *
 * To use Breadcrumbs, you need to configure its {@see Breadcrumbs::items()} method,
 * which specifies the items to be displayed. For example:
 *
 * ```php
 * echo Breadcrumbs::widget()
 *     ->itemTemplate("<li><i>{link}</i></li>\n") // template for all links
 *     ->items([
 *         [
 *             'label' => 'Post Category',
 *             'url' => 'post-category/view?id=10',
 *             'template' => "<li><b>{link}</b></li>\n", // template for this link only
 *         ],
 *         ['label' => 'Sample Post', 'url' => 'post/edit?id=1'],
 *         'Edit',
 *     ]);
 * ```
 *
 * Because breadcrumbs usually appear on nearly every page of a website, you may consider placing this widget
 * in a layout view. You can use a view parameter (e.g. `$this->setParameter('breadcrumbs', [...])`) to configure
 * the items in different views.
 *
 * In the layout view, assign this view parameter to the {@see Breadcrumbs::items()} method like the following:
 *
 * ```php
 * echo Breadcrumbs::widget()->items($this->getParameter('breadcrumbs', []));
 * ```
 *
 * In the examples above, `$this` is an instance of {@see ViewInterface} and refers to the current view.
 */
final class Breadcrumbs extends Widget
{
    private string $activeItemTemplate = "<li class=\"active\">{link}</li>\n";
    private array $attributes = ['class' => 'breadcrumb'];
    private ?array $homeItem = ['label' => 'Home', 'url' => '/'];
    private array $items = [];
    private string $itemTemplate = "<li>{link}</li>\n";
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
     * Returns a new instance with the HTML attributes for the breadcrumbs container tag.
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
     * Returns a new instance with the specified first item in the breadcrumbs (called home link).
     *
     * If `null` is specified, the home item will not be rendered.
     *
     * @param ?array $value Home item configuration. The format is the same as an item in {@see items()}.
     *
     * @psalm-param ?array{label: string, url?: string, template?: string, encode?: bool, ...} $value
     *
     * @throws InvalidArgumentException If an empty array is specified.
     */
    public function homeItem(?array $value): self
    {
        /** @psalm-suppress TypeDoesNotContainType */
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
     * @param ?string $value The id of the widget.
     *
     * @psalm-param ?non-empty-string $value
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
     *     'encode' => true, // optional, whether to HTML-encode the label, defaults to true
     * ]
     * ```
     *
     * If an item is active, you only need to specify its "label", and instead of writing `['label' => $label]`, you may
     * simply use `$label`.
     *
     * Additional array elements will be treated as HTML attributes for the hyperlink tag.
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
     *
     * @psalm-param list<array{label: string, url?: string, template?: string, encode?: bool, ...}|string> $value
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
     * Returns a new instance with the specified tag.
     *
     * @param string $value The container tag name. If an empty string is provided, the widget will not render
     * a wrapping container tag.
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
     * @throws InvalidArgumentException If an item has an invalid format.
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

        return empty($this->tag)
            ? $body
            : Html::normalTag($this->tag, PHP_EOL . $body, $this->attributes)->encode(false)->render();
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $item The item to be rendered. It must contain the "label" element. The "url", "template",
     * and "encode" are optional elements. Any additional elements are used as HTML attributes for the generated link.
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
            unset($item['template'], $item['label'], $item['url'], $item['encode']);
            $link = Html::a($label, $link, $item);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }
}
