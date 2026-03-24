# Yii Widgets Change Log

## 2.1.2 under development

- Enh #105: Explicitly import classes, functions, and constants in "use" section (@rustamwin)
- Chg #105: Raise the minimum PHP version to `8.1` (@rustamwin)
- Chg #105: Change PHP constraint in `composer.json` to `8.1 - 8.5` (@rustamwin)
- Enh #108: Bump minimal `yiisoft/html` version to `3.13` and add support for `^4.0` (@vjik)
- Bug #113: Fix `array_merge()` argument order in `Menu::renderItem()` so that item-level `linkAttributes` override widget-level ones (@WarLikeLaux)
- Enh #114: Add `readonly` to constructor-promoted properties in `Block`, `ContentDecorator`, and `FragmentCache` (@WarLikeLaux)
- Enh #123: Remove redundant `array_merge()` call with single argument in `Dropdown` (@WarLikeLaux)
- New #129: Add `id()` method to `Menu` and `Breadcrumbs` widgets (@WarLikeLaux)
- New #150: Add `map()` method to `Menu` and `Dropdown` for per-item transform before rendering (@WarLikeLaux)

## 2.1.1 September 23, 2025

- Chg #86, #95: Raise required `yiisoft/view` version to `10 - 12` (@vjik, @Tigrov)
- Bug #97: Fix `Block` behavior when content is "0" (@vjik)

## 2.1.0 February 19, 2023

- Chg: #71: Add support of `yiisoft/cache` version `^3.0` (@vjik)
- Chg: #71: Update `yiisoft/aliases` version to `^3.0` and `yiisoft/view` version to `^8.0` (@rustamwin)

## 2.0.0 January 27, 2023

- Chg #67: Upgrade `yiisoft/widget` version to `^2.0` (@rustamwin)

## 1.1.0 December 21, 2022

- Enh #59: Fix phpdocs and check type for array normalized in `Dropdown::class`, `Menu::class` (@terabytesoftw)
- Enh #64: Add supports of `yiisoft/html` version `^3.0` and `yiisoft/view` version `^7.0` (@vjik)

## 1.0.0 October 12, 2022

- Initial release.
