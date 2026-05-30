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

## Container wrapper

You can wrap the breadcrumbs in a container tag (e.g. `<nav>`) using `container(true)`:

```php
echo Breadcrumbs::widget()
    ->container(true)
    ->containerTag('nav')
    ->containerAttributes(['aria-label' => 'breadcrumb'])
    ->items([
        ['label' => 'Category', 'url' => '/category'],
        'Current Page',
    ])
    ->render();
```

The code above generates the following HTML:

```html
<nav aria-label="breadcrumb">
<ul class="breadcrumb">
<li><a href="/">Home</a></li>
<li><a href="/category">Category</a></li>
<li class="active">Current Page</li>
</ul>
</nav>
```

## JSON-LD structured data

The widget can generate [Schema.org BreadcrumbList](https://schema.org/BreadcrumbList) structured data
in JSON-LD format. This helps search engines understand the page hierarchy.

```php
echo Breadcrumbs::widget()
    ->jsonLd(true)
    ->items([
        ['label' => 'Category', 'url' => 'https://example.com/category'],
        'Current Page',
    ])
    ->render();
```

This appends a `<script type="application/ld+json">` block after the breadcrumbs HTML:

```json
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "/"},
        {"@type": "ListItem", "position": 2, "name": "Category", "item": "https://example.com/category"},
        {"@type": "ListItem", "position": 3, "name": "Current Page"}
    ]
}
```

JSON-LD is used instead of microdata or RDFa because it lives in a separate `<script>` block and does not
require modifications to the breadcrumb HTML tags. This avoids conflicts with custom `itemTemplate`
and `activeItemTemplate`.

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Breadcrumbs`
class with the specified value.

Method | Description | Default
-------|-------------|---------
`activeItemTemplate(string $value)`| Template used to render each active item in the breadcrumbs | `"<li class=\"active\">{link}</li>\n"`
`attributes(array $valuesMap)` | HTML attributes for the breadcrumbs container | `['class' => 'breadcrumb']`
`container(bool $value)` | Whether to wrap breadcrumbs in a container tag | `false`
`containerAttributes(array $valuesMap)` | HTML attributes for the container wrapper | `[]`
`containerClass(string $value)` | CSS class for the container wrapper | `''`
`containerTag(string $value)` | Tag name for the container wrapper | `'nav'`
`homeItem(?array $value)` | The first item in the breadcrumbs (called home link) | `['label' => 'Home', 'url' => '/']`
`id(?string $value)` | The widget ID | `null`
`items(array $value)` | List of items to appear in the breadcrumbs | `[]`
`itemTemplate(string $value)` | Template used to render each inactive item in the breadcrumbs | `"<li>{link}</li>\n"`
`jsonLd(bool $value)` | Whether to render JSON-LD structured data ([BreadcrumbList](https://schema.org/BreadcrumbList)) | `false`
`tag(string $value)` | The container tag name | `'ul'`
