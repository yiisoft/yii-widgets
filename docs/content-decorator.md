# Content decorator widget

This widget records all output between the `begin()` and `end()` calls, passes them to the provided
view file as `$content` and then reproduces the rendering result.

For more information about view rendering,
[see here](https://github.com/yiisoft/view/blob/master/docs/basic-functionality.md#rendering).

## Usage

```php
use Yiisoft\Yii\Widgets\ContentDecorator;

ContentDecorator::widget()
    ->viewFile('@app/views/layouts/main.php')
    ->parameters(['name' => 'value'])
    ->begin();

echo 'Some content here.';

ContentDecorator::end();
```

Note that the path alias is passed to the `viewFile()` method. You can specify either
the absolute path to the view file or its alias. For more information about aliases,
see the description of the [yiisoft/aliases](https://github.com/yiisoft/aliases) package.

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\ContentDecorator`
class with the specified value.

Method | Description | Default
-------|-------------|---------
`parameters(array $value)` | The parameters (name => value) to be extracted and made available in the decorative view. | `[]`
`viewFile(string $value)` | The view file that will be used to decorate the content enclosed by this widget. | `''`
