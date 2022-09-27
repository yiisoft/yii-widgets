<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_key_exists;
use function implode;
use function is_array;
use function strtr;

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
 *         ['label' => 'Sample Post', 'url' => 'post/edit?id=1',
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
    private string $tag = 'ul';
    private array $options = ['class' => 'breadcrumb'];
    private ?array $homeItem = ['label' => 'Home', 'url' => '/'];
    private array $items = [];
    private string $itemTemplate = "<li>{link}</li>\n";
    private string $activeItemTemplate = "<li class=\"active\">{link}</li>\n";
    private bool $encodeLabels = true;

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
     * Disables encoding for labels and returns a new instance.
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;
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
     * If a item is active, you only need to specify its "label", and instead of writing `['label' => $label]`, you may
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
     * Each individual item can override global {@see encodeLabels} param like the following:
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
     * Returns a new instance with the specified options.
     *
     * @param array $value The HTML attributes for the menu's container tag. The following special options are
     * recognized:
     *
     * - tag: string, defaults to "ul", the tag name of the item container tags. Set to false to disable container tag.
     *   See also {@see \Yiisoft\Html\Html::tag()}.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;
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
     * Renders the widget.
     *
     * @throws JsonException
     *
     * @return string The result of widget execution to be outputted.
     */
    protected function run(): string
    {
        if (empty($this->items)) {
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

            if (!empty($item)) {
                $items[] = $this->renderItem(
                    $item,
                    isset($item['url']) ? $this->itemTemplate : $this->activeItemTemplate
                );
            }
        }

        $body = implode('', $items);

        return empty($this->tag)
            ? $body
            : Html::tag($this->tag, $body, $this->options)
                ->encode(false)
                ->render()
            ;
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $item The item to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template The template to be used to rendered the link. The token "{link}" will be replaced by the
     * link.
     *
     * @throws InvalidArgumentException|JsonException if `$item` does not have "label" element.
     *
     * @return string The rendering result.
     */
    private function renderItem(array $item, string $template): string
    {
        if (!array_key_exists('label', $item)) {
            throw new InvalidArgumentException('The "label" element is required for each item.');
        }

        $encodeLabel = ArrayHelper::remove($item, 'encode', $this->encodeLabels);
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

        if (isset($item['template'])) {
            $template = $item['template'];
        }

        if (isset($item['url'])) {
            $link = $item['url'];
            unset($item['template'], $item['label'], $item['url']);
            $link = Html::a($label, $link, $item);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }
}
