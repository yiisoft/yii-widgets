<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

/**
 * Provides fluent conditional configuration for widgets.
 */
trait WhenTrait
{
    /**
     * Applies the callback if the condition is true, returns this instance unchanged otherwise.
     *
     * @param callable(static): static $callback The callback to apply.
     */
    public function when(bool $condition, callable $callback): static
    {
        return $condition ? $callback($this) : $this;
    }
}
