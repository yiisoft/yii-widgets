<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Helper;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\I;
use Yiisoft\Html\Tag\Span;

final class Normalizer
{
    public static function dropdown(array $items): array
    {
        /**
         * @psalm-var array[] $items
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        foreach ($items as $i => $child) {
            if (is_array($child)) {
                $items[$i]['label'] = self::label($child);
                /** @var bool */
                $items[$i]['active'] = $child['active'] ?? false;
                /** @var bool */
                $items[$i]['disabled'] = $child['disabled'] ?? false;
                /** @var string */
                $items[$i]['link'] = $child['link'] ?? '/';
                /** @var string */
                $items[$i]['icon'] = $child['icon'] ?? '';
                /** @var array */
                $items[$i]['iconAttributes'] = $child['iconAttributes'] ?? [];
                /** @var string */
                $items[$i]['iconClass'] = $child['iconClass'] ?? '';
                /** @var array */
                $items[$i]['iconContainerAttributes'] = $child['iconContainerAttributes'] ?? [];
                /** @var bool */
                $items[$i]['visible'] = $child['visible'] ?? true;

                if (isset($child['items']) && is_array($child['items'])) {
                    $items[$i]['items'] = self::dropdown($child['items']);
                }
            }
        }

        return $items;
    }

    /**
     * Normalize the given array of items for the menu.
     *
     * @param array $items The items to be normalized.
     * @param string $currentPath The current path.
     * @param bool $activateItems Whether to activate items.
     *
     * @return array The normalized array of items.
     */
    public static function menu(array $items, string $currentPath, bool $activateItems): array
    {
        /**
         * @psalm-var array[] $items
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        foreach ($items as $i => $child) {
            if (is_array($child)) {
                if (isset($child['items']) && is_array($child['items'])) {
                    $items[$i]['items'] = self::menu($child['items'], $currentPath, $activateItems);
                } else {
                    $items[$i]['label'] = self::label($child);

                    /** @var string */
                    $link = $child['link'] ?? '/';
                    /** @var bool */
                    $active = $child['active'] ?? false;

                    if ($active === false) {
                        $items[$i]['active'] = self::isItemActive($link, $currentPath, $activateItems);
                    }

                    /** @var bool */
                    $items[$i]['disabled'] = $child['disabled'] ?? false;
                    /** @var string */
                    $items[$i]['icon'] = $child['icon'] ?? '';
                    /** @var array */
                    $items[$i]['iconAttributes'] = $child['iconAttributes'] ?? [];
                    /** @var string */
                    $items[$i]['iconClass'] = $child['iconClass'] ?? '';
                    /** @var bool */
                    $items[$i]['visible'] = $child['visible'] ?? true;
                }
            }
        }

        return $items;
    }

    public static function renderLabel(
        string $label,
        string $icon,
        array $iconAttributes,
        string $iconClass,
        array $iconContainerAttributes
    ): string {
        $html = '';

        if ($iconClass !== '') {
            Html::addCssClass($iconAttributes, $iconClass);
        }

        if ($icon !== '' || $iconAttributes !== [] || $iconClass !== '') {
            $i = I::tag()->addAttributes($iconAttributes)->content($icon);
            $html = Span::tag()->addAttributes($iconContainerAttributes)->content($i)->encode(false)->render();
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking match that specified in the `url` option of the menu item.
     *
     * @param string $link The link of the menu item.
     * @param string $currentPath The current path.
     * @param bool $activateItems Whether to activate items having no link.
     *
     * @return bool Whether the menu item is active.
     */
    private static function isItemActive(string $link, string $currentPath, bool $activateItems): bool
    {
        return $link === $currentPath && $activateItems;
    }

    private static function label(array $item): string
    {
        if (!isset($item['label'])) {
            throw new InvalidArgumentException('The "label" option is required.');
        }

        if (!is_string($item['label'])) {
            throw new InvalidArgumentException('The "label" option must be a string.');
        }

        if ($item['label'] === '' && !isset($item['icon'])) {
            throw new InvalidArgumentException('The "label" cannot be an empty string.');
        }

        /** @var bool */
        $encode = $item['encode'] ?? true;

        return $encode ? Html::encode($item['label']) : $item['label'];
    }
}
