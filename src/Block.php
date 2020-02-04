<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

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
class Block extends Widget
{
    private string $id;

    /**
     * @var bool whether to render the block content in place. Defaults to false, meaning the captured block content
     * will not be displayed.
     */
    private bool $renderInPlace = false;

    private WebView $webView;

    public function __construct(WebView $webview)
    {
        $this->webView = $webview;
    }

    /**
     * Starts recording a block.
     */
    public function start(): void
    {
        ob_start();
        ob_implicit_flush(0);
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
            $this->webView->setBlocks($this->id, $block);
        }

        return '';
    }

    /**
     * @param string $value
     *
     * @return Block
     */
    public function id(string $value): Block
    {
        $this->id = $value;

        return $this;
    }

    /**
     * {@see $renderInPlace}
     *
     * @param bool $value
     *
     * @return Block
     */
    public function renderInPlace(bool $value): Block
    {
        $this->renderInPlace = $value;

        return $this;
    }
}
