# Alert widget

The widget provides contextual feedback messages for typical user actions with the handful of available and flexible alert messages.

## CSS frameworks documentation

- [Bootstrap5](https://getbootstrap.com/docs/5.0/components/alerts/)
- [Bulma](https://bulma.io/documentation/elements/notification/)
- [Tailwind](https://tailwindui.com/components/application-ui/feedback/alerts)

## Assets

This widget is meant to be used with your CSS framework of choice. The framework could be added either by [registering its assets](https://github.com/yiisoft/assets#general-usage), or by adding it directly via HTML `link` and `script` tags. The package does not provide any JavaScript code for the close button as well.

## Usage

Example for Bootstrap5 with icon:

```php
use Yiisoft\Yii\Widgets\Alert;

echo Alert::widget()
    ->body('An example alert with an icon')
    ->bodyContainerClass('align-items-center d-flex')
    ->buttonAttributes(['data-bs-dismiss' => 'alert', 'aria-label' => 'Close'])
    ->bodyContainer(true)
    ->buttonClass('btn-close')
    ->buttonLabel()
    ->class('alert alert-primary alert-dismissible fade show')
    ->iconClass('bi bi-exclamation-triangle-fill flex-shrink-0 me-2')
    ->id('w0-alert')
    ->layoutBody('{icon}{body}{button}')
    ->render();
```

The code above generates the following HTML:

```html
<div id="w0-alert" class="alert alert-primary alert-dismissible fade show" role="alert">
    <div class="align-items-center d-flex">
        <div><i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i></div>
        <span>An example alert with an icon</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
```

Example for Bulma:

```php
use Yiisoft\Yii\Widgets\Alert;

echo Alert::widget()
    ->body('An example alert.')
    ->buttonClass('delete')
    ->class('notification is-danger')
    ->id('w0-alert')
    ->layoutBody('{body}{button}')
    ->render();
```

The code above generates the following HTML:

```html
<div id="w0-alert" class="notification is-danger" role="alert">
    <span>An example alert.</span>
    <button type="button" class="delete">&times;</button>
</div>
```

Example for Tailwind:

```php
use Yiisoft\Yii\Widgets\Alert;

echo Alert::widget()
    ->body('<b>Holy smokes!</b> Something seriously bad happened.')
    ->bodyClass('align-middle inline-block mr-8')
    ->buttonClass('absolute bottom-0 px-4 py-3 right-0 top-0')
    ->buttonOnClick('closeAlert()')
    ->class('bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative')
    ->id('w0-alert')
    ->render();
```

The code above generates the following HTML:

```html
<div id="w0-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <span class="align-middle inline-block mr-8"><b>Holy smokes!</b> Something seriously bad happened.</span>
    <button type="button" class="absolute bottom-0 px-4 py-3 right-0 top-0" onclick="closeAlert()">&times;</button>
</div>
```

For other examples of different Alert designs you can see [AlertTest](https://github.com/yiisoft/yii-widgets/blob/master/tests/Alert/AlertTest.php)

## Setters

All setters are immutable and return a new instance of the `Yiisoft\Yii\Widgets\Alert` class with the specified value.

Method | Description | Default
-------|-------------|---------
`attributes(array $valuesMap)` | HTML attributes for the alert container | `[]`
`body(string $value)` | The message body | `''`
`bodyAttributes(array $valuesMap)` | HTML attributes for the message body tag | `[]`
`bodyClass(string $value)` | CSS class for the message body tag | `''`
`bodyContainer(bool $value)` | Allows you to add an extra wrapper for the body | `false`
`bodyContainerAttributes(array $valuesMap)` | HTML attributes for extra wrapper for the body | `[]`
`bodyContainerClass(string $value)` | CSS class for extra wrapper for the body | `''`
`bodyTag(string $value)` | The tag for the message body | `span`
`buttonAttributes(array $valuesMap)` | The attributes for rendering the button tag | `[]`
`buttonClass(string $value)` | The CSS class for the close button | `''`
`buttonLabel(string $value)` | The label for the button | `&times;`
`buttonOnClick(string $value)` | The JavaScript for the button's `onclick` event | `''`
`class(string $value)` | The CSS class for the widget | `''`
`header(string $value)` | The message header | `''`
`headerAttributes(array $valuesMap)` | HTML attributes for the message header | `[]`
`headerClass(string $value)` | CSS class for the message header tag | `''`
`headerContainer(bool $value)` | Allows you to add an extra wrapper for the header | `false`
`headerContainerAttributes(array $valuesMap)` | HTML attributes for extra wrapper for the header | `[]`
`headerContainerClass(string $value)` | CSS class for extra wrapper for the header | `''`
`headerTag(string $value)` | The tag for the message header | `<span>`
`iconAttributes(array $valuesMap)` | HTML attributes for the icon | `[]`
`iconClass(string $value)` | CSS class for the icon | `''`
`iconContainerAttributes(array $valuesMap)` | HTML attributes for the icon container | `[]`
`iconText(string $value)` | The text for the icon | `''`
`id(string $value)` | The unique identifier of the Alert | `null`
`layoutBody(string $value)` | The layout for the body | `''`
`layoutHeader(string $value)` | The layout for the header | `''`
