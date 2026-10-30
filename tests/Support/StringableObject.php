<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\Support;

use Stringable;

/**
 * A `Stringable` object that returns the string passed to the constructor.
 */
final class StringableObject implements Stringable
{
    public function __construct(
        private readonly string $value,
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
