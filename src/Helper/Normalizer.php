<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Helper;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Span;

final class Normalizer
{
    /**
     * Normalize the given array of items for the dropdown.
     */
    public static function dropdown(array $items): array
    {
        /**
         * @psalm-var array[] $items
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        foreach ($items as $i => $child) {
            if (is_array($child)) {
                $items[$i]['label'] = self::renderLabel(
                    self::label($child),
                    self::icon($child),
                    self::iconAttributes($child),
                    self::iconClass($child),
                    self::iconContainerAttributes($child),
                );
                $items[$i]['active'] = self::active($child, '', '', false);
                $items[$i]['disabled'] = self::disabled($child);
                $items[$i]['enclose'] = self::enclose($child);
                $items[$i]['headerAttributes'] = self::headerAttributes($child);
                $items[$i]['itemContainerAttributes'] = self::itemContainerAttributes($child);
                $items[$i]['link'] = self::link($child, '/');
                $items[$i]['linkAttributes'] = self::linkAttributes($child);
                $items[$i]['toggleAttributes'] = self::toggleAttributes($child);
                $items[$i]['visible'] = self::visible($child);

                if (isset($child['items']) && is_array($child['items'])) {
                    $items[$i]['items'] = self::dropdown($child['items']);
                } else {
                    $items[$i]['items'] = [];
                }
            }
        }

        return $items;
    }

    /**
     * Normalize the given array of items for the menu.
     */
    public static function menu(
        array $items,
        string $currentPath,
        bool $activateItems,
        array $iconContainerAttributes = []
    ): array {
        /**
         * @psalm-var array[] $items
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        foreach ($items as $i => $child) {
            if (is_array($child)) {
                if (isset($child['items']) && is_array($child['items'])) {
                    $items[$i]['items'] = self::menu(
                        $child['items'],
                        $currentPath,
                        $activateItems,
                        $iconContainerAttributes,
                    );
                } else {
                    $items[$i]['link'] = self::link($child);
                    $items[$i]['linkAttributes'] = self::linkAttributes($child);
                    $items[$i]['active'] = self::active(
                        $child,
                        $items[$i]['link'],
                        $currentPath,
                        $activateItems
                    );
                    $items[$i]['disabled'] = self::disabled($child);
                    $items[$i]['visible'] = self::visible($child);
                    $items[$i]['label'] = self::renderLabel(
                        self::label($child),
                        self::icon($child),
                        self::iconAttributes($child),
                        self::iconClass($child),
                        self::iconContainerAttributes($child, $iconContainerAttributes),
                    );
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

        $tagName = self::iconTagName($iconAttributes);

        unset($iconAttributes['tagName']);

        if ($iconClass !== '') {
            Html::addCssClass($iconAttributes, $iconClass);
        }

        if ($icon !== '' || $iconAttributes !== [] || $iconClass !== '') {
            $tag = Html::tag($tagName)->attributes($iconAttributes)->content($icon);

            $html = match ($tagName) {
                'i' => Span::tag()->attributes($iconContainerAttributes)->content($tag)->encode(false)->render(),
                default => $tag->render(),
            };
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }

    private static function active(array $item, string $link, string $currentPath, bool $activateItems): bool
    {
        if (!array_key_exists('active', $item)) {
            return self::isItemActive($link, $currentPath, $activateItems);
        }

        return is_bool($item['active']) ? $item['active'] : false;
    }

    private static function disabled(array $item): bool
    {
        return array_key_exists('disabled', $item) && is_bool($item['disabled']) ? $item['disabled'] : false;
    }

    private static function enclose(array $item): bool
    {
        return array_key_exists('enclose', $item) && is_bool($item['enclose']) ? $item['enclose'] : true;
    }

    private static function headerAttributes(array $item): array
    {
        return array_key_exists('headerAttributes', $item) && is_array($item['headerAttributes'])
            ? $item['headerAttributes']
            : [];
    }

    private static function icon(array $item): string
    {
        return array_key_exists('icon', $item) && is_string($item['icon']) ? $item['icon'] : '';
    }

    private static function iconAttributes(array $item): array
    {
        return array_key_exists('iconAttributes', $item) && is_array($item['iconAttributes'])
            ? $item['iconAttributes'] : [];
    }

    private static function iconClass(array $item): string
    {
        return array_key_exists('iconClass', $item) && is_string($item['iconClass']) ? $item['iconClass'] : '';
    }

    private static function iconContainerAttributes(array $item, array $iconContainerAttributes = []): array
    {
        return array_key_exists('iconContainerAttributes', $item) && is_array($item['iconContainerAttributes'])
            ? $item['iconContainerAttributes'] : $iconContainerAttributes;
    }

    private static function iconTagName(array $item): string
    {
        return array_key_exists('tagName', $item) && is_string($item['tagName']) && $item['tagName'] !== ''
            ? $item['tagName'] : 'i';
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

    private static function itemContainerAttributes(array $item): array
    {
        return array_key_exists('itemContainerAttributes', $item) && is_array($item['itemContainerAttributes'])
            ? $item['itemContainerAttributes'] : [];
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

    private static function link(array $item, string $defaultValue = ''): string
    {
        return array_key_exists('link', $item) && is_string($item['link']) ? $item['link'] : $defaultValue;
    }

    private static function linkAttributes(array $item): array
    {
        return array_key_exists('linkAttributes', $item) && is_array($item['linkAttributes'])
            ? $item['linkAttributes'] : [];
    }

    private static function toggleAttributes(array $item): array
    {
        return array_key_exists('toggleAttributes', $item) && is_array($item['toggleAttributes'])
            ? $item['toggleAttributes'] : [];
    }

    private static function visible(array $item): bool
    {
        return array_key_exists('visible', $item) && is_bool($item['visible']) ? $item['visible'] : true;
    }
}
