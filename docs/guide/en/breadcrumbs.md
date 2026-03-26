# Breadcrumbs widget

This widget is a simple navigation component.

Note that widget only renders the HTML tags about the breadcrumbs. It does do any styling.
You are responsible to provide CSS styles to make it look like a real breadcrumbs.

## Usage

```php
use Yiisoft\Yii\Widgets\Breadcrumbs;

echo Breadcrumbs::widget()
    ->homeItem([
        'label' => 'Home',
        'url' => 'site/index',
        'class' => 'home',
    ])
    ->items([
        [
            'label' => 'Category',
            'url' => 'site/category',
            'class' => 'category',
        ],
        [
            'label' => 'Item',
            'url' => 'site/category/item',
            'class' => 'item',
        ],
    ])
    ->render();
```

The code above generates the following HTML:

```html
<ul class="breadcrumb">
    <li><a class="home" href="site/index">Home</a></li>
    <li><a class="category" href="site/category">Category</a></li>
    <li><a class="item" href="site/category/item">Item</a></li>
</ul>
```

## Lazy evaluation

The `items()` method accepts a `Closure` in addition to an array. The Closure is called once
when `render()` runs, deferring item resolution until render time.

This can be useful when the widget instance is created and configured before the data for items
is available. For example, if a preconfigured widget is passed to a layout and the actual items
are determined later during request handling:

```php
// Widget is configured early
$breadcrumbs = Breadcrumbs::widget()
    ->homeItem(['label' => 'Home', 'url' => '/'])
    ->items(fn() => $categoryRepository->getBreadcrumbTrail($currentCategory));

// Items are resolved only when render() is called
echo $breadcrumbs->render();
```

The Closure must return an array in the same format as the regular `items()` parameter.
Array input works exactly as before.

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Breadcrumbs`
class with the specified value.

Method | Description | Default
-------|-------------|---------
`activeItemTemplate(string $value)`| Template used to render each active item in the breadcrumbs | `"<li class=\"active\">{link}</li>\n"`
`attributes(array $valuesMap)` | HTML attributes for the breadcrumbs container | `['class' => 'breadcrumb']`
`homeItem(?array $value)` | The first item in the breadcrumbs (called home link) | `['label' => 'Home', 'url' => '/']`
`items(array\|Closure $value)` | List of items, or a Closure returning the list for lazy evaluation | `[]`
`itemTemplate(string $value)` | Template used to render each inactive item in the breadcrumbs | `"<li>{link}</li>\n"`
`tag(string $value)` | The container tag name | `'ul'`
