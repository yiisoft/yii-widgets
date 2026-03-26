# Dropdown widget

The dropdown widget is a simple widget that allows you to select a single value from a list of options.

## Usage

```php
echo Yiisoft\Yii\Widgets\Dropdown::widget()
    ->id('dropdown-example')
    ->items(
        [
            [
                'label' => 'Action',
                'link' => '#',
                'items' => [
                    ['label' => 'Action', 'link' => '#'],
                    ['label' => 'Another action', 'link' => '#'],
                    ['label' => 'Something else here', 'link' => '#'],
                    '-',
                    ['label' => 'Separated link', 'link' => '#'],
                ],
            ],
        ]
    )
    ->toggleType('link')
    ->toggleType('split')
    ->render();
```

The code above generates the following HTML:

```html
<div class="btn-group">
    <button type="button" class="btn btn-danger">Action</button>
    <button type="button" id="dropdown-example" class="btn btn-danger dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Action</span></button>
    <ul class="dropdown-menu" aria-labelledby="dropdown-example">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Separated link</a></li>
    </ul>
</div>
```

## Lazy evaluation

The `items()` method accepts a `Closure` in addition to an array. The Closure is called once
when `render()` runs, deferring item resolution until render time.

This can be useful when the widget instance is created and configured before the data for items
is available. For example, if a preconfigured widget is passed to a layout and the actual items
are determined later during request handling:

```php
// Widget is configured early
$dropdown = Dropdown::widget()
    ->containerClass('dropdown')
    ->items(fn() => $menuService->getDropdownItems($currentUser));

// Items are resolved only when render() is called
echo $dropdown->render();
```

The Closure must return an array in the same format as the regular `items()` parameter.
Array input works exactly as before.

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Dropdown` class with the specified value.

Method | Description | Default
-------|-------------|---------
`activeClass(string $value)` | The CSS class to be added to the active item | `active`
`container(bool $value)` | If the container is enabled, or not | `true`
`containerAttributes(array $valuesMap)` | The HTML attributes for the container tag | `[]`
`containerClass(string $value)` | The CSS class for the container tag | `''`
`containerTag(string $value)` | The tag name for the container tag | `div`
`disabledClass(string $value)` | The CSS class to be added to the disabled item | `disabled`
`dividerAttributes(array $valuesMap)` | The HTML attributes for the divider tag | `[]`
`dividerClass(string $value)` | The CSS class for the divider tag | `dropdown-divider`
`dividerTag(string $value)` | The tag name for the divider tag | `hr`
`headerClass(string $value)` | The CSS class for the header tag | `''`
`headerTag(string $value)` | The tag name for the header tag | `span`
`id(string $value)` | The ID of the widget | `''`
`itemClass(string $value)` | The CSS class for the item tag | `''`
`itemContainer(bool $value)` | Item container to use. If false, the item container will not be rendered | `true`
`itemContainerAttributes(array $valuesMap)` | The HTML attributes for the item container tag | `[]`
`itemContainerClass(string $value)` | The CSS class for the item container tag | `''`
`itemContainerTag(string $value)` | The tag name for the item container tag | `li`
`itemTag(string $value)` | The tag name for the item tag | `a`
`items(array\|Closure $value)` | List of menu items, or a Closure returning the list for lazy evaluation | `[]`
`itemsContainerAttributes(array $valuesMap)` | The HTML attributes for the items container tag | `[]`
`itemsContainerClass(string $value)` | The CSS class for the items container tag | `''`
`itemsContainerTag(string $value)` | The tag name for the items container tag | `ul`
`splitButtonAttributes(array $valuesMap)` | The HTML attributes for the split button tag | `[]`
`splitButtonClass(string $value)` | The CSS class for the split button tag | `''`
`splitButtonSpanClass(string $value)` | The CSS class for the split button span tag | `''`
`toggleAttributes(array $valuesMap)` | The HTML attributes for the toggle tag | `[]`
`toggleClass(string $value)` | The CSS class for the toggle tag | `''`
`toggleType(string $value)` | The type of the toggle button | `button`

### Items structure is an array of the following structure

```php
[
    [
        'label' => '',
        'active' => false,
        'disabled' => false,
        'enclose' => true,
        'encode' => true,
        'headerAttributes' => [],
        'link' => '',
        'linkAttributes' => [],
        'icon' => '',
        'iconAttributes' => [],
        'items' => [],
        'itemsContainerAttributes' => [],
        'visible' => true,
    ],
]
