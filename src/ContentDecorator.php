<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Throwable;
use Yiisoft\Aliases\Aliases;
use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function ob_get_clean;
use function ob_start;

/**
 * ContentDecorator records all output between {@see Widget::begin()} and {@see Widget::end()} calls,
 * passes it to the given view file as `$content` and then echoes rendering result.
 *
 * ```php
 * <?= ContentDecorator::widget()
 *     ->viewFile('@app/views/layouts/base.php')
 *     ->parameters([])
 *     ->begin();
 * ?>
 *
 * some content here
 *
 * <?= ContentDecorator::end() ?>
 * ```
 */
final class ContentDecorator extends Widget
{
    private array $parameters = [];
    private string $viewFile = '';

    public function __construct(private Aliases $aliases, private WebView $webView)
    {
    }

    /**
     * Returns a new instance with the specified parameters.
     *
     * @param array $value The parameters (name => value) to be extracted and made available in the decorative view.
     */
    public function parameters(array $value): self
    {
        $new = clone $this;
        $new->parameters = $value;

        return $new;
    }

    /**
     * Returns a new instance with the specified view file.
     *
     * @param string $value The view file that will be used to decorate the content enclosed by this widget.
     * This can be specified as either the view file path or alias path.
     */
    public function viewFile(string $value): self
    {
        $new = clone $this;
        $new->viewFile = $this->aliases->get($value);

        return $new;
    }

    /**
     * Starts recording a content.
     */
    public function begin(): ?string
    {
        parent::begin();

        ob_start();

        return null;
    }

    /**
     * Ends recording a content.
     *
     * This method stops output buffering and saves the rendering result as a `$content`
     * variable and then echoes rendering result.
     *
     * @throws Throwable|ViewNotFoundException
     *
     * @return string The result of widget execution to be outputted.
     */
    public function render(): string
    {
        $parameters = $this->parameters;
        $parameters['content'] = ob_get_clean();

        /** render under the existing context */
        return $this->webView->render($this->viewFile, $parameters);
    }
}
