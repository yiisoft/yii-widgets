# Menu widget

Menu displays a multi-level menu using nested HTML lists.

The main method of Menu is `items()`, which specifies the possible items in the menu.
A menu item can contain sub-items which specify the sub-menu under that menu item.

Menu checks the current path to toggle certain menu items with active state.

Note that widget only renders the HTML tags about the menu. It does do any styling.
You are responsible to provide CSS styles to make it look like a real menu.

## Usage

```php
echo Yiisoft\Yii\Widgets\Menu::widget()
    ->currentPath('/active')
    ->dropdownDefinitions(
        [
            'container()' => [false],
            'dividerClass()' => ['dropdown-divider'],
            'headerClass()' => ['dropdown-header'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [
                [
                    'aria-expanded' => 'false',
                    'data-bs-toggle' => 'dropdown',
                    'role' => 'button',
                ],
            ],
            'toggleClass()' => ['dropdown-toggle'],
            'toggleType()' => ['link'],
        ]
    )
    ->items(
        [
            ['label' => 'Active', 'link' => '/active'],
                [
                    'label' => 'Dropdown',
                    'link' => '#',
                    'items' => [
                        ['label' => 'Action', 'link' => '#'],
                        ['label' => 'Another action', 'link' => '#'],
                        ['label' => 'Something else here', 'link' => '#'],
                        '-',
                        ['label' => 'Separated link', 'link' => '#'],
                    ],
                ],
                ['label' => 'Link', 'link' => '#'],
                ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
        ]
    )
    ->render();
```

The code above generates the following HTML:

```html
<ul>
    <li><a class="active" href="/active" aria-current="page">Active</a></li>
    <li>
        <a class="dropdown-toggle" href="#" aria-expanded="false" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
    </li>
    <li><a href="#">Link</a></li>
    <li><a class="disabled" href="#">Disabled</a></li>
</ul>
```

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Menu` class with the specified value.

Method | Description | Default
-------|-------------|---------
`activateItems(bool $value)` | Whether to activate parent menu items when one of the corresponding child menu items is active | `true`
`activeClass(string $value)` | The CSS class to be appended to the active menu item | `'active'`
`afterAttributes(array $valuesMap)` | The HTML attributes for the after container | `[]`
`afterClass(string $value)` | The CSS class to be appended to the after container | `''`
`afterContent(string $value)` | The content to be appended after the menu | `''`
`afterTag(string $value)` | The tag name for the after container | `'span'`
`attributes(array $valuesMap)` | HTML attributes for the menu container | `[]`
`beforeAttributes(array $valuesMap)` | The HTML attributes for the before container | `[]`
`beforeClass(string $value)` | The CSS class to be appended to the before container | `''`
`beforeContent(string $value)` | The content to be prepended before the menu | `''`
`beforeTag(string $value)` | The tag name for the before container | `'span'`
`class(string $value)` | The CSS class to be appended to the menu container | `''`
`container(bool $value)` | Whether to render the menu container tag | `true`
`currentPath(string $value)` | Allows you to assign the current path | `''`
`disabledClass(string $value)` | The CSS class to be appended to the disabled menu item | `'disabled'`
`dropdownContainerClass(string $value)` | The CSS class to be appended to the dropdown container | `'dropdown'`
`dropdownContainerTag(string $value)` | The tag name for the dropdown container | `'li'`
`dropdownDefinitions(array $valuesMap)` | The config for dropdown widget | `[]`
`firstItemClass(string $value)` | The CSS class for the first item in the main menu or each submenu | `null`
`iconContainerAttributes(array $valuesMap)` | The HTML attributes for the icon container | `[]`
`items(array $value)` | List of menu items | `[]`
`itemsContainer(bool $value)` | Whether to render the items container tag | `true`
`itemsContainerAttributes(array $valuesMap)` | The HTML attributes for the items container | `[]`
`itemsTag(string $value)` | The tag name for the items container | `'li'`
`lastItemClass(string $value)` | The CSS class for the last item in the main menu or each submenu | `null`
`linkAttributes(array $valuesMap)` | The HTML attributes for the link | `[]`
`linkClass(string $value)` | The CSS class to be appended to the link | `''`
`linkTag(string $value)` | The tag name for the link | `'a'`
`template(string $value)` | The template used to render the main menu | `'{items}'`

Items structure is an array of the following structure:

```php
[
    [
        'label' => '',
        'active' => false,
        'disabled' => false,
        'encode' => true,
        'items' => [],
        'itemsContainerAttributes' => [],
        'link' => '',
        'linkAttributes' => [],
        'icon' => '',
        'iconAttributes' => [],
        'iconClass' => '',
        'itemsContainerAttributes' => [],
        'visible' => true,
    ],
]
```
