<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Helper;

use Stringable;

use function array_key_exists;
use function is_array;
use function is_bool;
use function is_string;

/**
 * Removes empty submenus and redundant dividers from unnormalized `Menu` and `Dropdown` items.
 *
 * Removed submenus are validated the same way as rendered ones, so pruning never hides invalid items.
 *
 * @internal
 */
final class Pruner
{
    /**
     * Removes redundant items from the given unnormalized dropdown items.
     *
     * Dividers are the string items and the array items labeled `-` without an icon, which is how they are rendered.
     * Leading and trailing dividers are removed, and consecutive ones are collapsed into one. An item with nested
     * items is removed when none of its nested items remain visible apart from dividers. Hidden items are kept as is
     * because they are not rendered anyway. Items with no nested items, headers, disabled and raw content items are
     * content and are kept.
     */
    public static function dropdown(array $items): array
    {
        return self::prune($items);
    }

    /**
     * Removes empty submenus from the given unnormalized menu items and prunes the items of the remaining submenus
     * as {@see dropdown()} does. Top-level items without nested items are kept as is.
     */
    public static function menu(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            if (is_array($item) && self::visible($item) && self::hasNestedItems($item)) {
                $nested = self::prune($item['items'], $hasContent);

                if (!$hasContent) {
                    self::validate($item);
                    continue;
                }

                $item['items'] = $nested;
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param-out bool $hasContent Set to whether any visible item other than a divider remains.
     */
    private static function prune(array $items, ?bool &$hasContent = null): array
    {
        $result = [];
        $divider = null;
        $hasContent = false;

        foreach ($items as $item) {
            if (is_array($item) && !self::visible($item)) {
                $result[] = $item;
                continue;
            }

            if (self::hasNestedItems($item)) {
                $nested = self::prune($item['items'], $nestedHasContent);

                if (!$nestedHasContent) {
                    self::validate($item);
                    continue;
                }

                $item['items'] = $nested;
            } elseif (self::isDivider($item)) {
                if ($hasContent && $divider === null) {
                    $divider = $item;
                }

                continue;
            }

            if ($divider !== null) {
                $result[] = $divider;
                $divider = null;
            }

            $result[] = $item;
            $hasContent = true;
        }

        return $result;
    }

    /**
     * Validates a removed submenu with its nested items as rendering it would.
     */
    private static function validate(array $item): void
    {
        Normalizer::dropdown([$item]);
    }

    /**
     * @psalm-assert-if-true array{items: non-empty-array} $item
     */
    private static function hasNestedItems(mixed $item): bool
    {
        return is_array($item) && isset($item['items']) && is_array($item['items']) && $item['items'] !== [];
    }

    /**
     * Whether the given visible item without nested items is rendered as a divider.
     */
    private static function isDivider(mixed $item): bool
    {
        if (is_string($item)) {
            return true;
        }

        if (!is_array($item) || !isset($item['label'])) {
            return false;
        }

        $label = $item['label'];

        return (is_string($label) || $label instanceof Stringable)
            && (string) $label === '-'
            && (!isset($item['icon']) || !is_string($item['icon']) || $item['icon'] === '')
            && (!isset($item['iconAttributes']) || !is_array($item['iconAttributes']) || $item['iconAttributes'] === [])
            && (!isset($item['iconClass']) || !is_string($item['iconClass']) || $item['iconClass'] === '');
    }

    private static function visible(array $item): bool
    {
        return !array_key_exists('visible', $item) || !is_bool($item['visible']) || $item['visible'];
    }
}
