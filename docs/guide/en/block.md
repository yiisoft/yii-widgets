# Block widget

Imagine that a certain part of layouts should change depending on the content of the view.
A "blocks" mechanism is provided for transmitting such chunks.

For more information about sharing data among views,
[see here](https://github.com/yiisoft/view/blob/master/docs/guide/en/basic-functionality.md#sharing-data-among-views).

## Usage

The general idea is that you're defining block default in a view or layout:

```php
use Yiisoft\Yii\Widgets\Block;

Block::widget()
    ->id('my-block')
    ->begin();
    echo 'Nothing.';
Block::end();
```

And then redefining the default value in the views:

```php
use Yiisoft\Yii\Widgets\Block;

Block::widget()
    ->id('my-block')
    ->begin();
    echo 'Umm... hello?';
Block::end();
```

In the subspecies, show the block:

```php
/**
 * @var Yiisoft\View\WebView $this
 */

echo $this->getBlock('my-block');
```

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Block` class with the specified value.

Method | Description | Default
-------|-------------|---------
`id(string $value)` | The unique identifier of the block | `''`
`renderInPlace()` | Enables in-place rendering of the block contents | `false`
