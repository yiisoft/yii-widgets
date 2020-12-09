<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;
use Throwable;

use Yiisoft\Aliases\Aliases;
use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

/**
 * ContentDecorator records all output between {@see begin()} and {@see end()]} calls, passes it to the given view file
 * as `$content` and then echoes rendering result.
 *
 * ```php
 * <?= ContentDecorator::widget()
 *     ->viewFile('@app/views/layouts/base.php')
 *     ->params([])
 *     ->begin(); ?>
 *
 * some content here
 *
 * <?= ContentDecorator::end() ?>
 * ```
 */
final class ContentDecorator extends Widget
{
    private Aliases $aliases;
    private array $params = [];
    private ?string $viewFile = null;
    private WebView $webView;

    public function __construct(Aliases $aliases, WebView $webView)
    {
        $this->aliases = $aliases;
        $this->webView = $webView;
    }

    public function begin(): ?string
    {
        parent::begin();
        /** Starts recording a clip. */
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
        return null;
    }

    /**
     * Ends recording a clip.
     *
     * This method stops output buffering and saves the rendering result as a named clip in the controller.
     *
     * @throws Throwable|ViewNotFoundException
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run(): string
    {
        $params = $this->params;

        $params['content'] = ob_get_clean();

        /** render under the existing context */
        return $this->webView->renderFile($this->viewFile, $params);
    }

    /**
     * @param array $value the parameters (name => value) to be extracted and made available in the decorative view.
     *
     * @return ContentDecorator
     */
    public function params(array $value): self
    {
        $this->params = $value;

        return $this;
    }

    /**
     * @param string|null $value the view file that will be used to decorate the content enclosed by this widget.
     * This can be specified as either the view file path or alias path.
     *
     * @return ContentDecorator
     */
    public function viewFile(?string $value): self
    {
        $this->viewFile = $aliases->get($value);

        return $this;
    }
}
