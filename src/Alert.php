<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

/**
 * Alert renders an alert component.
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 * @link https://bulma.io/documentation/elements/notification/
 * @link https://tailwindui.com/components/application-ui/feedback/alerts
 */
final class Alert extends Widget
{
    private array $attributes = [];
    private array $buttonAttributes = [];
    private string $buttonLabel = '&times;';
    private string $body = '';
    private array $bodyAttributes = [];
    /** @psalm-var non-empty-string */
    private ?string $bodyTag = 'span';
    private bool $bodyContainer = false;
    private array $bodyContainerAttributes = [];
    private string $header = '';
    private array $headerAttributes = [];
    private bool $headerContainer = false;
    private array $headerContainerAttributes = [];
    /** @psalm-var non-empty-string */
    private string $headerTag = 'span';
    private array $iconAttributes = [];
    private array $iconContainerAttributes = [];
    private string $iconText = '';
    private string $layoutHeader = '';
    private string $layoutBody = '{body}{button}';
    private array $parts = [];

    /**
     * The HTML attributes for the main widget tag.
     *
     * @param array $value Array of attribute name => attribute value pairs.
     *
     * @return static
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * The message body.
     *
     * @param string $value The message body.
     *
     * @return static
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;
        return $new;
    }

    /**
     * HTML attributes for the message body tag.
     *
     * @param array $value Array of attribute name => attribute value pairs.
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function bodyAttributes(array $value): self
    {
        $new = clone $this;
        $new->bodyAttributes = $value;
        return $new;
    }

    /**
     * CSS class for the message body tag.
     *
     * @param string $value CSS class name.
     *
     * @return static
     */
    public function bodyClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->bodyAttributes, $value);
        return $new;
    }

    /**
     * Allows you to add an extra wrapper for the message body.
     *
     * @param string|null $tag
     *
     * @return static
     */
    public function bodyTag(?string $tag = null): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Body tag must be a string and cannot be empty.');
        }

        $new = clone $this;
        $new->bodyTag = $tag;
        return $new;
    }

    /**
     * The attributes for rendering extra message wrapper.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function bodyContainerAttributes(array $value): self
    {
        $new = clone $this;
        $new->bodyContainerAttributes = $value;
        return $new;
    }

    /**
     * The CSS class for extra message wrapper.
     *
     * @param string $value
     *
     * @return static
     */
    public function bodyContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->bodyContainerAttributes, $value);
        return $new;
    }

    /**
     * Allows you to add an extra wrapper for the panel body.
     *
     * @param bool $value
     *
     * @return static
     */
    public function bodyContainer(bool $value): self
    {
        $new = clone $this;
        $new->bodyContainer = $value;
        return $new;
    }

    /**
     * The attributes for rendering the button tag.
     *
     * The button is displayed in the header of the modal window. Clicking on the button will hide the modal.
     *
     * If {@see buttonEnabled} is `false`, no button will be rendered.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function buttonAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonAttributes = $value;
        return $new;
    }

    /**
     * The CSS class for the button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->buttonAttributes, $value);
        return $new;
    }

    /**
     * The label for the button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonLabel(string $value = ''): self
    {
        $new = clone $this;
        $new->buttonLabel = $value;
        return $new;
    }

    /**
     * The onclick JavaScript for the button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonOnClick(string $value): self
    {
        $new = clone $this;
        $new->buttonAttributes['onclick'] = $value;
        return $new;
    }

    /**
     * Set attribute class for main widget tag.
     *
     * @param string $value
     *
     * @return static
     */
    public function class(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $value);
        return $new;
    }

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    /**
     * The header content.
     *
     * @param string $value
     *
     * @return static
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;
        return $new;
    }

    /**
     * The attributes for rendering the header content.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $value): self
    {
        $new = clone $this;
        $new->headerAttributes = $value;
        return $new;
    }

    /**
     * The CSS class for the header.
     *
     * @param string $value
     *
     * @return static
     */
    public function headerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->headerAttributes, $value);
        return $new;
    }

    /**
     * Allows you to add a div tag to the header extra wrapper.
     *
     * @param bool $value
     *
     * @return static
     */
    public function headerContainer(bool $value = true): self
    {
        $new = clone $this;
        $new->headerContainer = $value;
        return $new;
    }

    /**
     * The CSS class for the header extra wrapper.
     *
     * @param string $value
     *
     * @return static
     */
    public function headerContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->headerContainerAttributes, $value);
        return $new;
    }

    /**
     * The attributes for rendering the header.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerContainerAttributes(array $value): self
    {
        $new = clone $this;
        $new->headerContainerAttributes = $value;
        return $new;
    }

    /**
     * Set tag name for the header.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function headerTag(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Header tag must be a string and cannot be empty.');
        }

        $new = clone $this;
        $new->headerTag = $value;
        return $new;
    }

    /**
     * The attributes for rendering the `<i>` tag for the icon.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function iconAttributes(array $value): self
    {
        $new = clone $this;
        $new->iconAttributes = $value;
        return $new;
    }

    /**
     * Set icon CSS class.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->iconAttributes, $value);
        return $new;
    }

    /**
     * The attributes for rendering icon container.
     *
     * The rest of the options will be rendered as the HTML attributes of the icon container.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function iconContainerAttributes(array $value): self
    {
        $new = clone $this;
        $new->iconContainerAttributes = $value;
        return $new;
    }

    /**
     * The CSS class for the icon container.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconContainerClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->iconContainerAttributes, $value);
        return $new;
    }

    /**
     * Set icon text.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconText(string $value): self
    {
        $new = clone $this;
        $new->iconText = $value;
        return $new;
    }

    /**
     * Set layout body.
     *
     * @param string $value
     *
     * @return static
     */
    public function layoutBody(string $value): self
    {
        $new = clone $this;
        $new->layoutBody = $value;
        return $new;
    }

    /**
     * Set layout header.
     *
     * @param string $value
     *
     * @return static
     */
    public function layoutHeader(string $value): self
    {
        $new = clone $this;
        $new->layoutHeader = $value;
        return $new;
    }

    protected function run(): string
    {
        $new = clone $this;
        $div = Div::tag();

        if (!array_key_exists('id', $this->attributes)) {
            $div = $div->id(Html::generateId('alert-'));
        }

        if (!isset($new->parts['{button}'])) {
            $new->renderButton($new);
        }

        if (!isset($new->parts['{icon}'])) {
            $new->renderIcon($new);
        }

        if (!isset($new->parts['{body}'])) {
            $new->renderBody($new);
        }

        if (!isset($new->parts['{header}'])) {
            $new->renderHeader($new);
        }

        $contentAlert = $new->renderHeaderContainer($new) . PHP_EOL . $new->renderBodyContainer($new);

        return $new->body !== ''
            ? $div
                ->attribute('role', 'alert')
                ->attributes($new->attributes)
                ->content(PHP_EOL . trim($contentAlert) . PHP_EOL)
                ->encode(false)
                ->render()
            : '';
    }

    /**
     * Renders close button.
     */
    private function renderButton(self $new): void
    {
        $new->parts['{button}'] = PHP_EOL .
            Button::tag()
                ->attributes($new->buttonAttributes)
                ->content($new->buttonLabel)
                ->encode(false)
                ->type('button')
                ->render();
    }

    /**
     * Render icon.
     */
    private function renderIcon(self $new): void
    {
        $icon = CustomTag::name('i')
            ->attributes($new->iconAttributes)
            ->content($new->iconText)
            ->render();

        $new->parts['{icon}'] = PHP_EOL .
            Div::tag()
                ->attributes($new->iconContainerAttributes)
                ->content($icon)
                ->encode(false)
                ->render() . PHP_EOL;
    }

    /**
     * Render the alert message body.
     */
    private function renderBody(self $new): void
    {
        if ($new->bodyTag !== null) {
            $new->parts['{body}'] = CustomTag::name($new->bodyTag)
                ->attributes($new->bodyAttributes)
                ->content($new->body)
                ->encode(false)
                ->render();
        } else {
            $new->parts['{body}'] = $new->body;
        }
    }

    /**
     * Render the header.
     */
    private function renderHeader(self $new): void
    {
        $new->parts['{header}'] = CustomTag::name($new->headerTag)
            ->attributes($new->headerAttributes)
            ->content($new->header)
            ->encode(false)
            ->render();
    }

    /**
     * Render the header container.
     */
    private function renderHeaderContainer(self $new): string
    {
        $headerHtml = trim(strtr($new->layoutHeader, $new->parts));

        if ($new->headerContainer && $headerHtml !== '') {
            $headerHtml = Div::tag()
                ->attributes($new->headerContainerAttributes)
                ->content(PHP_EOL . $headerHtml . PHP_EOL)
                ->encode(false)
                ->render();
        }

        return $headerHtml;
    }

    /**
     * Render the panel body.
     */
    private function renderBodyContainer(self $new): string
    {
        $bodyHtml = trim(strtr($new->layoutBody, $new->parts));

        if ($new->bodyContainer) {
            $bodyHtml = Div::tag()
                ->attributes($new->bodyContainerAttributes)
                ->content(PHP_EOL . $bodyHtml . PHP_EOL)
                ->encode(false)
                ->render();
        }

        return $bodyHtml;
    }
}
