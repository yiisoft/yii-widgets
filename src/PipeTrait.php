<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

/**
 * Provides fluent pipe for composable widget configuration.
 */
trait PipeTrait
{
    /**
     * Passes this instance through the callback, returning the result.
     *
     * @param callable(static): static $callback The callback to apply.
     */
    public function pipe(callable $callback): static
    {
        return $callback($this);
    }
}
