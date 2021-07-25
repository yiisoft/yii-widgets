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
    ->currentPath('site/index')
    ->options(['class' => 'menu-menu'])
    ->items([
        [
            'label' => 'General',
            'options' => ['class' => 'general-menu'],
            'submenuTemplate' => "\n<ul class=\"general-items\">\n{items}\n</ul>\n",
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => 'site/index',
                ],
                [
                    'label' => 'Logout',
                    'url' => 'site/logout',
                    'options' => [
                        'id' => 'logout',
                        'class' => 'logout',
                    ],
                ],
            ]
        ],
        [
            'label' => 'Users',
            'options' => ['class' => 'user-menu'],
            'submenuTemplate' => "\n<ul class=\"user-items\">\n{items}\n</ul>\n",
            'items' => [
                ['label' => 'Manager', 'url' => 'user/index'],
                ['label' => 'Export', 'url' => 'user/export'],
            ],
        ],
    ])
;
```

The code above generates the following HTML:

```html
<ul class="main-menu">
    <li class="general-menu">General
        <ul class="general-items">
            <li class="active"><a href="site/index">Dashboard</a></li>
            <li id="logout" class="logout"><a href="site/logout">Logout</a></li>
        </ul>
    </li>
    <li class="user-menu">Users
        <ul class="user-items">
            <li><a href="user/index">Manager</a></li>
            <li><a href="user/export">Export</a></li>
        </ul>
    </li>
</ul>
```

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Menu` class with the specified value.

Method | Description | Default
-------|-------------|---------
`items(array $value)` | List of menu items. | `[]`
`itemOptions(array $value)` | List of HTML attributes shared by all menu items. | `[]`
`options(array $value)` | The HTML attributes for the menu's container tag. | `[]`
`currentPath(?string $value)` | Allows you to assign the current path. | `null`
`firstItemCssClass(?string $value)` | The CSS class for the first item in the main menu or each submenu. | `null`
`lastItemCssClass(?string $value)` | The CSS class for the last item in the main menu or each submenu. | `null`
`labelTemplate(string $value)`| The template used to render the body of a menu which is NOT a link. | `'{label}'`
`linkTemplate(string $value)` | The template used to render the body of a menu which is a link. | `'<a href="{url}">{label}</a>'`
`activeCssClass(string $value)` | The CSS class to be appended to the active menu item. | `'active'`
`deactivateItems()` | Disables activate items according to whether their current path. | `enabled`
`activateParents()` | Whether to activate parent menu items when one of the corresponding child menu items is active. | `disabled`
`showEmptyItems()` | Whether to show empty menu items. An empty menu item is one whose `url` option is not set and which has no visible child menu items. | `disabled`
`withoutEncodeLabels()` | Disables encoding for labels. | `enabled`
