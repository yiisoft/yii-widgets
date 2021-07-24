# Fragment cache widget

In some cases, caching fragments of content can significantly improve performance of your application. For example,
if a page displays a summary of yearly sales in a table, you can store this table in a cache to eliminate the time
needed to generate this table for each request.

For more information about content caching,
[see here](https://github.com/yiisoft/view/blob/master/docs/basic-functionality.md#content-caching).

## Usage

```php
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Yii\Widgets\FragmentCache;

// Creating a dynamic content instance
$dynamicContent = new DynamicContent(
    'dynamic-id',
    static function (array $parameters): string {
        return strtoupper("{$parameters['a']} - {$parameters['b']}");
    },
    ['a' => 'string-a', 'b' => 'string-b'],
);

// We use the widget as a wrapper over the content that should be cached:
FragmentCache::widget()->id('cache-id')->dynamicContents($dynamicContent)->begin();
    echo "Content to be cached ...\n";
    echo $dynamicContent->placeholder();
    echo "\nContent to be cached ...\n";
FragmentCache::end();
```

The code above generates the following HTML:

```
Content to be cached ...
STRING-A - STRING-B
Content to be cached ...
```

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\FragmentCache`
class with the specified value.

Method | Description | Default
-------|-------------|---------
`id(string $value)` | The unique identifier of the cache fragment. | `null`
`ttl(int $value)` | The number of seconds that the data can remain valid in cache. | `60`
`dynamicContents(DynamicContent ...$value)` | The dynamic content instances. | `null`
`variations(string ...$value)` | The factors that would cause the variation of the content being cached. | `[]`
