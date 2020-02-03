<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

/**
 * ContentDecorator records all output between {@see begin()} and {@see end()]} calls, passes it to the given view file
 * as `$content` and then echoes rendering result.
 *
 * ```php
 * <?php ContentDecorator::begin()
 *     ->viewFile('@app/views/layouts/base.php'),
 *     ->params([]),
 *     ->view($this),
 * ]) ?>
 *
 * some content here
 *
 * <?php ContentDecorator::end() ?>
 * ```
 */
class ContentDecorator extends Widget
{
    /**
     * @var array the parameters (name => value) to be extracted and made available in the decorative view.
     */
    private array $params = [];

    /**
     * @var string the view file that will be used to decorate the content enclosed by this widget. This can be
     * specified as either the view file path or alias path.
     */
    private ?string $viewFile = null;

    /**
     * @var WebView
     */
    private WebView $webView;

    public function __construct(WebView $webview)
    {
        $this->webView = $webview;
    }


    public function init(): void
    {
        // Starts recording a clip.
        ob_start();
        ob_implicit_flush(0);
    }

    /**
     * Ends recording a clip.
     * This method stops output buffering and saves the rendering result as a named clip in the controller.
     *
     * @return string the result of widget execution to be outputted.
     *
     * @throws \Throwable
     * @throws ViewNotFoundException
     */
    public function run(): string
    {
        $params = $this->params;

        $params['content'] = ob_get_clean();

        // render under the existing context
        return $this->webView->renderFile($this->viewFile, $params);
    }

    /**
     * {@see params}
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
     * {@see viewFilw}
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
