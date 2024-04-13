# Widget Dropdown

O widget Dropdown é um widget simples que permite selecionar um único valor em uma lista de opções.

## Uso

```php
echo Yiisoft\Yii\Widgets\Dropdown::widget()
    ->id('dropdown-example')
    ->items(
        [
            [
                'label' => 'Action',
                'link' => '#',
                'items' => [
                    ['label' => 'Action', 'link' => '#'],
                    ['label' => 'Another action', 'link' => '#'],
                    ['label' => 'Something else here', 'link' => '#'],
                    '-',
                    ['label' => 'Separated link', 'link' => '#'],
                ],
            ],
        ]
    )
    ->toggleType('link')
    ->toggleType('split')
    ->render();
```

O código acima gera o seguinte HTML:

```html
<div class="btn-group">
    <button type="button" class="btn btn-danger">Action</button>
    <button type="button" id="dropdown-example" class="btn btn-danger dropdown-toggle dropdown-toggle-split" aria-expanded="false" data-bs-toggle="dropdown"><span class="visually-hidden">Action</span></button>
    <ul class="dropdown-menu" aria-labelledby="dropdown-example">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Separated link</a></li>
    </ul>
</div>
```

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe `Yiisoft\Yii\Widgets\Menu` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`activeCssClass(string $value)` | A classe CSS a ser adicionada ao item ativo | `active`
`container(bool $value)` | Se o contêiner estiver habilitado ou não | `true`
`containerAttributes(array $valuesMap)` | Os atributos HTML da tag de contêiner | `[]`
`containerClass(string $value)` | A classe CSS para a tag container | `''`
`containerTag(string $value)` | O nome da tag do contêiner | `div`
`disabledClass(string $value)` | A classe CSS a ser adicionada ao item desabilitado | `disabled`
`dividerAttributes(array $valuesMap)` | Os atributos HTML da tag divisor | `[]`
`dividerClass(string $value)` | A classe CSS para a tag divisor | `dropdown-divider`
`dividerTag(string $value)` | O nome da tag do divisor | `hr`
`headerClass(string $value)` | A classe CSS para a tag de cabeçalho | `''`
`headerTag(string $value)` | O nome da tag de cabeçalho | `h6`
`id(string $value)` | O ID do widget | `''`
`itemClass(string $value)` | A classe CSS para a tag do item | `dropdown-item`
`itemContainer(string $value)` | Recipiente de itens a ser usado. Se for falso, o contêiner do item não será renderizado | `true`
`itemContainerAttributes(array $valuesMap)` | Os atributos HTML para a tag de contêiner de item | `[]`
`itemContainerClass(string $value)` | A classe CSS para a tag do contêiner do item | `dropdown-menu`
`itemContainerTag(string $value)` | O nome da tag do contêiner do item | `ul`
`itemTag(string $value)` | O nome da tag do item | `a`
`items(array $value)` | Lista de itens de menu no menu suspenso | `[]`
`itemsContainerAttributes(array $valuesMap)` | Os atributos HTML para a tag de contêiner de itens | `[]`
`itemsContainerClass(string $value)` | A classe CSS para a tag de contêiner de itens | `''`
`itemsContainerTag(string $value)` | O nome da tag do contêiner de itens | `li`
`splitButtonAttributes(array $valuesMap)` | Os atributos HTML para a tag do botão de divisão | `[]`
`splitButtonClass(string $value)` | A classe CSS para a tag do botão de divisão | `''`
`toggleAttributes(array $valuesMap)` | Os atributos HTML para a tag de alternância | `[]`
`toggleClass(string $value)` | A classe CSS para a tag de alternância | `''`
`toggleType(string $value)` | O tipo do botão de alternância | `button`

### A estrutura de itens é um array com a seguinte estrutura

```php
[
    [
        'label' => '',
        'active' => false,
        'disabled' => false,
        'enclose' => true,
        'encode' => true,
        'headerAttributes' => [],
        'link' => '',
        'linkAttributes' => [],
        'icon' => '',
        'iconAttributes' => [],
        'items' => [],
        'itemsContainerAttributes' => [],
        'visible' => true,
    ],
]
