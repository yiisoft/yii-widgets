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
    private string $buttonClass = '';
    private string $buttonLabel = '&times;';
    private string $buttonOnClick = '';
    private string $body = '';
    private array $bodyAttributes = [];
    private string $bodyClass = '';
    private bool $bodyContainer = false;
    private array $bodyContainerAttributes = [];
    private string $bodyContainerClass = '';
    /** @var non-empty-string */
    private string $bodyTag = 'span';
    private string $class = '';
    private ?string $id = null;
    private string $header = '';
    private array $headerAttributes = [];
    private string $headerClass = '';
    private bool $headerContainer = false;
    private array $headerContainerAttributes = [];
    private string $headerContainerClass = '';
    /** @var non-empty-string */
    private string $headerTag = 'span';
    private array $iconAttributes = [];
    private array $iconContainerAttributes = [];
    private string $iconContainerClass = '';
    private string $iconClass = '';
    private string $iconText = '';
    private string $layoutHeader = '';
    private string $layoutBody = '{body}{button}';
    private array $parts = [];

    /**
     * The HTML attributes for widget. The following special options are recognized.
     *
     * @param array $value
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
     * The message content in the alert component. Alert widget will also be treated as the message content, and will be
     * rendered before this.
     *
     * @param string $value
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
     * The attributes for rendering message content in the alert component.
     *
     * @param array $value
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
     * The CSS class for the alert panel body.
     *
     * @param string $value
     *
     * @return static
     */
    public function bodyClass(string $value): self
    {
        $new = clone $this;
        $new->bodyClass = $value;
        return $new;
    }

    /**
     * Allows you to add a div tag to the alert panel body.
     *
     * @param bool $value
     *
     * @return static
     */
    public function bodyContainer(bool $value = true): self
    {
        $new = clone $this;
        $new->bodyContainer = $value;
        return $new;
    }

    /**
     * The attributes for rendering the panel alert body.
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
     * The CSS class for the alert panel body.
     *
     * @param string $value
     *
     * @return static
     */
    public function bodyContainerClass(string $value): self
    {
        $new = clone $this;
        $new->bodyContainerClass = $value;
        return $new;
    }

    /**
     * Set tag name for the alert panel body.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function bodyTag(string $value): self
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Body tag must be a string and cannot be empty.');
        }

        $new = clone $this;
        $new->bodyTag = $value;
        return $new;
    }

    /**
     * The attributes for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window.
     *
     * If {@see closeButtonEnabled} is false, no close button will be rendered.
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
     * The CSS class for the close button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonClass(string $value): self
    {
        $new = clone $this;
        $new->buttonClass = $value;
        return $new;
    }

    /**
     * The label for the close button.
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
     * The onclick JavaScript for the close button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonOnClick(string $value = ''): self
    {
        $new = clone $this;
        $new->buttonOnClick = $value;
        return $new;
    }

    /**
     * Set attribute class for widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function class(string $value): self
    {
        $new = clone $this;
        $new->class = $value;
        return $new;
    }

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * The header content in the alert component. Alert widget will also be treated as the header content, and will be
     * rendered before this.
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
     * The attributes for rendering the header content in the alert component.
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
     * The CSS class for the alert panel header.
     *
     * @param string $value
     *
     * @return static
     */
    public function headerClass(string $value): self
    {
        $new = clone $this;
        $new->headerClass = $value;
        return $new;
    }

    /**
     * Allows you to add a div tag to the alert panel header.
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
     * The CSS class for the alert panel header.
     *
     * @param string $value
     *
     * @return static
     */
    public function headerContainerClass(string $value): self
    {
        $new = clone $this;
        $new->headerContainerClass = $value;
        return $new;
    }

    /**
     * The attributes for rendering the panel alert header.
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
     * Set tag name for the alert panel header.
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
     * The attributes for rendering the `<i>` tag for icons alerts.
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
     * Set icon css class in the alert component.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconClass(string $value): self
    {
        $new = clone $this;
        $new->iconClass = $value;
        return $new;
    }

    /**
     * The attributes for rendering the container `<i>` tag.
     *
     * The rest of the options will be rendered as the HTML attributes of the `<i>` tag.
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
     * The CSS class for the container `<i>` tag.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconContainerClass(string $value): self
    {
        $new = clone $this;
        $new->iconContainerClass = $value;
        return $new;
    }

    /**
     * Set icon text in the alert component.
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
     * Set layout the alert panel body.
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
     * Set layout the alert panel header.
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
        return $new->renderAlert($new);
    }

    /**
     * Render Alert.
     */
    private function renderAlert(self $new): string
    {
        $new->attributes['role'] = 'alert';
        $new->attributes['id'] ??= $new->id ?? Html::generateId('alert-');

        if (!isset($new->parts['{button}'])) {
            $new->renderCloseButton($new);
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

        $contentAlert = $new->renderPanelHeader($new) . PHP_EOL . $new->renderPanelBody($new);

        if ($new->class !== '') {
            Html::addCssClass($new->attributes, $new->class);
        }

        return $new->body !== ''
            ? Div::tag()
                ->attributes($new->attributes)
                ->content(PHP_EOL . trim($contentAlert) . PHP_EOL)
                ->encode(false)
                ->render()
            : '';
    }

    /**
     * Renders close button.
     */
    private function renderCloseButton(self $new): void
    {
        $new->parts['{button}'] = '';

        if ($new->buttonOnClick !== '') {
            $new->buttonAttributes['onclick'] = $new->buttonOnClick;
        }

        if ($new->buttonClass !== '') {
            Html::addCssClass($new->buttonAttributes, $new->buttonClass);
        }

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
        if ($new->iconClass !== '') {
            Html::addCssClass($new->iconAttributes, $new->iconClass);
        }

        if ($new->iconContainerClass !== '') {
            Html::addCssClass($new->iconContainerAttributes, $new->iconContainerClass);
        }

        $icon = CustomTag::name('i')->attributes($new->iconAttributes)->content($new->iconText)->render();

        $new->parts['{icon}'] = PHP_EOL .
            Div::tag()
                ->attributes($new->iconContainerAttributes)
                ->content($icon)
                ->encode(false)
                ->render() . PHP_EOL;
    }

    /**
     * Render the alert message.
     */
    private function renderBody(self $new): void
    {
        if ($new->bodyClass !== '') {
            Html::addCssClass($new->bodyAttributes, $new->bodyClass);
        }

        $new->parts['{body}'] = CustomTag::name($new->bodyTag)
            ->attributes($new->bodyAttributes)
            ->content($new->body)
            ->encode(false)
            ->render();
    }

    /**
     * Render the alert message header.
     */
    private function renderHeader(self $new): void
    {
        if ($new->headerClass !== '') {
            Html::addCssClass($new->headerAttributes, $new->headerClass);
        }

        $new->parts['{header}'] = CustomTag::name($new->headerTag)
            ->attributes($new->headerAttributes)
            ->content($new->header)
            ->encode(false)
            ->render();
    }

    /**
     * Render the alert panel header.
     */
    private function renderPanelHeader(self $new): string
    {
        $headerHtml = trim(strtr($new->layoutHeader, $new->parts));

        if ($new->headerContainerClass !== '') {
            Html::addCssClass($new->headerContainerAttributes, $new->headerContainerClass);
        }

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
     * Render the alert panel body.
     */
    private function renderPanelBody(self $new): string
    {
        $bodyHtml = trim(strtr($new->layoutBody, $new->parts));

        if ($new->bodyContainerClass !== '') {
            Html::addCssClass($new->bodyContainerAttributes, $new->bodyContainerClass);
        }

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
