<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use RuntimeException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function ob_end_clean;
use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;

/**
 * Block records all output between {@see Widget::begin()} and {@see Widget::end()} calls and stores it in.
 *
 * The general idea is that you're defining block default in a view or layout:
 *
 * ```php
 * <?php Block::widget()->id('my-block')->begin() ?>
 *     Nothing.
 * <?php Block::end() ?>
 * ```
 *
 * And then overriding default in views:
 *
 * ```php
 * <?php Block::widget()->id('my-block')->begin() ?>
 *     Umm... hello?
 * <?php Block::end() ?>
 * ```
 *
 * in subviews show block:
 *
 * ```php
 * <?= $this->getBlock('my-block') ?>
 * ```
 */
final class Block extends Widget
{
    private ?string $id = null;
    private bool $renderInPlace = false;
    private WebView $webView;

    public function __construct(WebView $webView)
    {
        $this->webView = $webView;
    }

    /**
     * Starts recording a block.
     */
    public function begin(): ?string
    {
        parent::begin();
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
        return null;
    }

    /**
     * Ends recording a block.
     *
     * This method stops output buffering and saves the rendering result as a named block in the view.
     *
     * @return string The result of widget execution to be outputted.
     */
    protected function run(): string
    {
        if ($this->id === null) {
            ob_end_clean();
            throw new RuntimeException('You must assign the "id" using the "id()" setter.');
        }

        $block = ob_get_clean();

        if ($this->renderInPlace) {
            return $block;
        }

        if (!empty($block)) {
            $this->webView->setBlock($this->id, $block);
        }

        return '';
    }

    /**
     * Returns a new instance with the specified Widget ID.
     *
     * @param string $value The Widget ID.
     *
     * @return self
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * Returns a new instance with the specified flag of "render in place".
     *
     * @param bool $value Whether to render the block content in place. Defaults to false, meaning the captured block
     * content will not be displayed.
     *
     * @return self
     */
    public function renderInPlace(bool $value): self
    {
        $new = clone $this;
        $new->renderInPlace = $value;
        return $new;
    }
}
