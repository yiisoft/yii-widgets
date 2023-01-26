<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use RuntimeException;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function ob_end_clean;
use function ob_get_clean;
use function ob_start;

/**
 * Block records all output between {@see Widget::begin()} and {@see Widget::end()} calls and stores it in.
 *
 * The general idea is that you're defining block default in a view or layout:
 *
 * ```php
 * <?php Block::widget()
 *     ->id('my-block')
 *     ->begin() ?>
 *     Nothing.
 * <?php Block::end() ?>
 * ```
 *
 * And then overriding default in views:
 *
 * ```php
 * <?php Block::widget()
 *     ->id('my-block')
 *     ->begin() ?>
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
    private string $id = '';
    private bool $renderInPlace = false;

    public function __construct(private WebView $webView)
    {
    }

    /**
     * Starts recording a block.
     */
    public function begin(): string|null
    {
        parent::begin();

        ob_start();

        return null;
    }

    /**
     * Returns a new instance with the specified Widget ID.
     *
     * @param string $value The Widget ID.
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Enables in-place rendering and returns a new instance.
     *
     * Without calling this method, the captured content of the block is not displayed.
     */
    public function renderInPlace(): self
    {
        $new = clone $this;
        $new->renderInPlace = true;

        return $new;
    }

    /**
     * Ends recording a block.
     *
     * This method stops output buffering and saves the rendering result as a named block in the view.
     *
     * @return string The result of widget execution to be outputted.
     */
    public function render(): string
    {
        if ($this->id === '') {
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
}
