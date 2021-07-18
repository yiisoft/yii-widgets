<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_key_exists;
use function is_array;

/**
 * Breadcrumbs displays a list of links indicating the position of the current page in the whole site hierarchy.
 *
 * For example, breadcrumbs like "Home / Sample Post / Edit" means the user is viewing an edit page for the
 * "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home" to return to the homepage.
 *
 * To use Breadcrumbs, you need to configure its {@see Breadcrumbs::links()} method,
 * which specifies the links to be displayed. For example:
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget()
 *     -> itemTemplate() => "<li><i>{link}</i></li>\n", // template for all links
 *     -> links() => [
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
 * You can use a view common parameter (e.g. `$this->getCommonParameter('breadcrumbs')`) to configure the links in
 * different views. In the layout view, you assign this view parameter to the {@see Breadcrumbs::links()} method
 * like the following:
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget()
 *     ->links($this->hasCommonParameter('breadcrumbs') ? $this->getCommonParameter('breadcrumbs') : []);
 * ```
 */
final class Breadcrumbs extends Widget
{
    private string $tag = 'ul';
    private array $options = ['class' => 'breadcrumb'];
    private bool $encodeLabels = true;
    private bool $homeLink = true;
    private array $homeUrlLink = [];
    private array $links = [];
    private string $itemTemplate = "<li>{link}</li>\n";
    private string $activeItemTemplate = "<li class=\"active\">{link}</li>\n";

    /**
     * Renders the widget.
     *
     * @throws JsonException
     *
     * @return string the result of widget execution to be outputted.
     */
    protected function run(): string
    {
        if (empty($this->links)) {
            return '';
        }

        $links = [];

        if ($this->homeLink === true) {
            $links[] = $this->renderItem([
                'label' => 'Home',
                'url' => '/',
            ], $this->itemTemplate);
        } elseif (!empty($this->homeUrlLink)) {
            $links[] = $this->renderItem($this->homeUrlLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }

            if (!empty($link)) {
                $links[] = $this->renderItem(
                    $link,
                    isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate
                );
            }
        }

        $body = implode('', $links);

        return empty($this->tag)
            ? $body
            : Html::tag($this->tag, $body, $this->options)->encode(false)->render()
        ;
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the
     * link.
     *
     * @throws InvalidArgumentException|JsonException if `$link` does not have "label" element.
     *
     * @return string the rendering result
     */
    protected function renderItem(array $link, string $template): string
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }

    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * @param array $value the HTML attributes for the menu's container tag. The following special options are
     * recognized:
     *
     * - tag: string, defaults to "ul", the tag name of the item container tags. Set to false to disable container tag.
     *   See also {@see \Yiisoft\Html\Html::tag()}.
     *
     * @return self
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
     * @param bool $value Whether the labels for menu items should be HTML-encoded.
     *
     * @return self
     */
    public function encodeLabels(bool $value): self
    {
        $new = clone $this;
        $new->encodeLabels = $value;
        return $new;
    }

    /**
     * @param bool $value The first hyperlink in the breadcrumbs (called home link). If this property is true, it will
     * default to a link pointing to HomeUrl '\' with the label 'Home'. If this property is false, the home link will
     * not be rendered.
     *
     * @return self
     */
    public function homeLink(bool $value): self
    {
        $new = clone $this;
        $new->homeLink = $value;
        return $new;
    }

    public function homeUrlLink(array $value): self
    {
        $new = clone $this;
        $new->homeUrlLink = $value;
        return $new;
    }

    /**
     * Returns a new instance with the specified list of links.
     *
     * @param array $value List of links to appear in the breadcrumbs. If this property is empty, the widget will not
     * render anything. Each array element represents a single link in the breadcrumbs with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     * If a link is active, you only need to specify its "label", and instead of writing `['label' => $label]`, you may
     * simply use `$label`.
     *
     * Additional array elements for each link will be treated as the HTML attributes for the hyperlink tag.
     * For example, the following link specification will generate a hyperlink with CSS class `external`:
     *
     * ```php
     * [
     *     'label' => 'demo',
     *     'url' => 'http://example.com',
     *     'class' => 'external',
     * ]
     * ```
     *
     * Each individual link can override global {@see encodeLabels} param like the following:
     *
     * ```php
     * [
     *     'label' => '<strong>Hello!</strong>',
     *     'encode' => false,
     * ]
     * ```
     *
     * @return self
     */
    public function links(array $value): self
    {
        if (!array_key_exists('label', $value)) {
            throw new InvalidArgumentException('The "label" element is required for each link.');
        }

        $new = clone $this;
        $new->links = $value;
        return $new;
    }

    /**
     * Returns a new instance with the specified item template.
     *
     * @param string $value The template used to render each inactive item in the breadcrumbs.
     * The token `{link}` will be replaced with the actual HTML link for each inactive item.
     *
     * @return self
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
     *
     * @return self
     */
    public function activeItemTemplate(string $value): self
    {
        $new = clone $this;
        $new->activeItemTemplate = $value;
        return $new;
    }
}
