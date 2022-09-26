<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\I;
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
        $div = Div::tag();
        $parts = [];

        if (!array_key_exists('id', $this->attributes)) {
            $div = $div->id(Html::generateId('alert-'));
        }

        $parts['{button}'] = $this->renderButton();
        $parts['{icon}'] = $this->renderIcon();
        $parts['{body}'] = $this->renderBody();
        $parts['{header}'] = $this->renderHeader();

        $contentAlert = $this->renderHeaderContainer($parts) . PHP_EOL . $this->renderBodyContainer($parts);

        return $this->body !== ''
            ? $div
                ->attribute('role', 'alert')
                ->addAttributes($this->attributes)
                ->content(PHP_EOL . trim($contentAlert) . PHP_EOL)
                ->encode(false)
                ->render()
            : '';
    }

    /**
     * Renders close button.
     */
    private function renderButton(): string
    {
        return PHP_EOL .
            Button::tag()
                ->addAttributes($this->buttonAttributes)
                ->content($this->buttonLabel)
                ->encode(false)
                ->type('button')
                ->render();
    }

    /**
     * Render icon.
     */
    private function renderIcon(): string
    {
        return PHP_EOL .
            Div::tag()
                ->addAttributes($this->iconContainerAttributes)
                ->content(I::tag()->addAttributes($this->iconAttributes)->content($this->iconText)->render())
                ->encode(false)
                ->render() .
            PHP_EOL;
    }

    /**
     * Render the alert message body.
     */
    private function renderBody(): string
    {
        return $this->bodyTag !== null
            ? Html::normalTag($this->bodyTag, $this->body, $this->bodyAttributes)->encode(false)->render()
            : $this->body;
    }

    /**
     * Render the header.
     */
    private function renderHeader(): string
    {
        return Html::normalTag($this->headerTag, $this->header, $this->headerAttributes)->encode(false)->render();
    }

    /**
     * Render the header container.
     */
    private function renderHeaderContainer(array $parts): string
    {
        $headerHtml = trim(strtr($this->layoutHeader, $parts));

        return $this->headerContainer && $headerHtml !== ''
            ? Div::tag()
                ->addAttributes($this->headerContainerAttributes)
                ->content(PHP_EOL . $headerHtml . PHP_EOL)
                ->encode(false)
                ->render()
            : $headerHtml;
    }

    /**
     * Render the panel body.
     */
    private function renderBodyContainer(array $parts): string
    {
        $bodyHtml = trim(strtr($this->layoutBody, $parts));

        return $this->bodyContainer
            ? Div::tag()
                ->addAttributes($this->bodyContainerAttributes)
                ->content(PHP_EOL . $bodyHtml . PHP_EOL)
                ->encode(false)
                ->render()
            : $bodyHtml;
    }
}
