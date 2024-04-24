# Widget Alert

O widget fornece mensagens de feedback contextuais para ações típicas do usuário com algumas mensagens de alerta disponíveis e flexíveis.

## Documentação do framework CSS

- [Bootstrap5](https://getbootstrap.com/docs/5.0/components/alerts/)
- [Bulma](https://bulma.io/documentation/elements/notification/)
- [Tailwind](https://tailwindui.com/components/application-ui/feedback/alerts)

## Assets (Ativos)

Este widget pode ser usado com a estrutura CSS de sua escolha. A estrutura pode ser adicionada [registrando seus ativos](https://github.com/yiisoft/assets#general-usage) ou adicionando-a diretamente por meio das tags HTML `link` e `script`. O pacote não fornece nenhum código JavaScript para o botão Fechar.

## Uso

Exemplo para Bootstrap5 com ícone:

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

O código acima gera o seguinte HTML:

```html
<div id="w0-alert" class="alert alert-primary alert-dismissible fade show" role="alert">
    <div class="align-items-center d-flex">
        <div><i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i></div>
        <span>An example alert with an icon</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

Exemplo para Bulma:

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

O código acima gera o seguinte HTML:

```html
<div id="w0-alert" class="notification is-danger" role="alert">
    <span>An example alert.</span>
    <button type="button" class="delete">&times;</button>
</div>
```

Exemplo para Tailwind:

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

O código acima gera o seguinte HTML:

```html
<div id="w0-alert" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <span class="align-middle inline-block mr-8"><b>Holy smokes!</b> Something seriously bad happened.</span>
    <button type="button" class="absolute bottom-0 px-4 py-3 right-0 top-0" onclick="closeAlert()">&times;</button>
</div>
```

Para outros exemplos de designs de alertas diferentes, você pode ver em [AlertTest](https://github.com/yiisoft/yii-widgets/blob/master/tests/Alert/AlertTest.php)

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe `Yiisoft\Yii\Widgets\Alert` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`attributes(array $valuesMap)` | Atributos HTML para o contêiner de alerta | `[]`
`body(string $value)` | O corpo da mensagem | `''`
`bodyAttributes(array $valuesMap)` | Atributos HTML para a tag do corpo da mensagem | `[]`
`bodyClass(string $value)` | Classe CSS para a tag do corpo da mensagem | `''`
`bodyContainer(bool $value)` | Permite adicionar um wrapper extra para o corpo | `false`
`bodyContainerAttributes(array $valuesMap)` | Atributos HTML para wrapper extra para o corpo | `[]`
`bodyContainerClass(string $value)` | Classe CSS para wrapper extra para o corpo | `''`
`bodyTag(string $value)` | A tag para o corpo da mensagem | `span`
`buttonAttributes(array $valuesMap)` | Os atributos para renderizar a tag do botão | `[]`
`buttonClass(string $value)` | A classe CSS para o botão "Fechar" | `''`
`buttonLabel(string $value)` | O rótulo do botão | `&times;`
`buttonOnClick(string $value)` | O JavaScript para o evento `onclick` do botão | `''`
`class(string $value)` | A classe CSS do widget | `''`
`header(string $value)` | O cabeçalho da mensagem | `''`
`headerAttributes(array $valuesMap)` | Atributos HTML para o cabeçalho da mensagem | `[]`
`headerClass(string $value)` | Classe CSS para a tag de cabeçalho da mensagem | `''`
`headerContainer(bool $value)` | Permite adicionar um wrapper extra para o cabeçalho | `false`
`headerContainerAttributes(array $valuesMap)` | Atributos HTML para wrapper extra para o cabeçalho | `[]`
`headerContainerClass(string $value)` | Classe CSS para wrapper extra para o cabeçalho | `''`
`headerTag(string $value)` | A tag para o cabeçalho da mensagem | `<span>`
`iconAttributes(array $valuesMap)` | Atributos HTML para o ícone | `[]`
`iconClass(string $value)` | Classe CSS para o ícone | `''`
`iconContainerAttributes(array $valuesMap)` | Atributos HTML para o contêiner de ícones | `[]`
`iconText(string $value)` | O texto do ícone | `''`
`id(string $value)` | O identificador exclusivo do Alerta | `null`
`layoutBody(string $value)` | O layout do corpo | `''`
`layoutHeader(string $value)` | O layout do cabeçalho | `''`
