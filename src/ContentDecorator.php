<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Throwable;
use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;

/**
 * ContentDecorator records all output between {@see begin()} and {@see end()]} calls, passes it to the given view file
 * as `$content` and then echoes rendering result.
 *
 * ```php
 * <?= ContentDecorator::begin()
 *     ->viewFile('@app/views/layouts/base.php')
 *     ->params([])
 *     ->view($this)
 *     ->start(); ?>
 *
 * some content here
 *
 * <?= ContentDecorator::end() ?>
 * ```
 */
final class ContentDecorator extends Widget
{
    /**
     * @var array the parameters (name => value) to be extracted and made available in the decorative view.
     */
    private array $params = [];

    /**
     * @var string|null the view file that will be used to decorate the content enclosed by this widget. This can be
     * specified as either the view file path or alias path.
     */
    private ?string $viewFile = null;

    private WebView $webView;

    public function __construct(WebView $webView)
    {
        $this->webView = $webView;
    }

    public function start(): void
    {
        /** Starts recording a clip. */
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
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
     * {@see $params}
     *
     * @param array $value
     *
     * @return ContentDecorator
     */
    public function params(array $value): ContentDecorator
    {
        $this->params = $value;

        return $this;
    }

    /**
     * {@see $viewFile}
     *
     * @param string $value
     *
     * @return ContentDecorator
     */
    public function viewFile(string $value): ContentDecorator
    {
        $this->viewFile = $value;

        return $this;
    }
}
