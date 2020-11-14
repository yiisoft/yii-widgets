<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;

/**
 * Block records all output between {@see begin()} and {@see end()} calls and stores it in
 *
 * The general idea is that you're defining block default in a view or layout:
 *
 * ```php
 * <?php $this->beginBlock('index') ?>
 * Nothing.
 * <?php $this->endBlock() ?>
 * ```
 *
 * And then overriding default in views:
 *
 * ```php
 * <?php $this->beginBlock('index') ?>
 * Umm... hello?
 * <?php $this->endBlock() ?>
 * ```
 *
 * in subviews show block:
 *
 * <?= $this->getBlock('index') ?>
 *
 * Second parameter defines if block content should be outputted which is desired when rendering its content but isn't
 * desired when redefining it in subviews.
 */
final class Block extends Widget
{
    private string $id;
    private bool $renderInPlace = false;
    private WebView $webView;

    public function __construct(WebView $webView)
    {
        $this->webView = $webView;
    }

    /**
     * Starts recording a block.
     */
    public function start(): void
    {
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
    }

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run(): string
    {
        $block = ob_get_clean();

        if ($this->renderInPlace) {
            return $block;
        }

        if (!empty($block)) {
            $this->webView->setBlock($this->id, $block);
        }

        return '';
    }

    public function id(string $value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param bool $value whether to render the block content in place. Defaults to false, meaning the captured block
     * content will not be displayed.
     *
     * @return $this
     */
    public function renderInPlace(bool $value): self
    {
        $this->renderInPlace = $value;

        return $this;
    }
}
