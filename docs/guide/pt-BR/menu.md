# Widget Menu

O widget "Menu" exibe um menu multinível usando listas HTML aninhadas.

O método principal do Menu é `items()`, que especifica os possíveis itens do menu.
Um item de menu pode conter subitens que especificam o submenu desse item de menu.

O widget "Menu" verifica o caminho atual para alternar determinados itens de menu com estado ativo.

Observe que o widget renderiza apenas as tags HTML do menu. Ele permite qualquer estilo.
Você é responsável por fornecer estilos CSS para que pareça um menu real.

## Uso

```php
echo Yiisoft\Yii\Widgets\Menu::widget()
    ->currentPath('/active')
    ->dropdownDefinitions(
        [
            'container()' => [false],
            'dividerClass()' => ['dropdown-divider'],
            'headerClass()' => ['dropdown-header'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [
                [
                    'aria-expanded' => 'false',
                    'data-bs-toggle' => 'dropdown',
                    'role' => 'button',
                ],
            ],
            'toggleClass()' => ['dropdown-toggle'],
            'toggleType()' => ['link'],
        ]
    )
    ->items(
        [
            ['label' => 'Active', 'link' => '/active'],
                [
                    'label' => 'Dropdown',
                    'link' => '#',
                    'items' => [
                        ['label' => 'Action', 'link' => '#'],
                        ['label' => 'Another action', 'link' => '#'],
                        ['label' => 'Something else here', 'link' => '#'],
                        '-',
                        ['label' => 'Separated link', 'link' => '#'],
                    ],
                ],
                ['label' => 'Link', 'link' => '#'],
                ['label' => 'Disabled', 'link' => '#', 'disabled' => true],
        ]
    )
    ->render();
```

O código acima gera o seguinte HTML:

```html
<ul>
    <li><a class="active" href="/active" aria-current="page">Active</a></li>
    <li>
        <a class="dropdown-toggle" href="#" aria-expanded="false" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
    </li>
    <li><a href="#">Link</a></li>
    <li><a class="disabled" href="#">Disabled</a></li>
</ul>
```

## Removendo submenus vazios

Depois de ocultar itens com `visible` ou `filter()`, um submenu pode ficar apenas com divisores, e o seu botão ainda
seria renderizado. Ative `pruneItems()` para limpar isso antes da renderização:

- um item cujos itens aninhados estão todos ocultos ou são divisores é removido junto com o seu botão, mesmo que tenha
  o seu próprio link;
- divisores no início e no fim são removidos, e divisores consecutivos são reduzidos a um.

Tanto `'-'` quanto `['label' => '-']` são divisores. Um rótulo `-` com ícone ou link é um item comum. Itens sem itens aninhados
(incluindo `'items' => []`), cabeçalhos, itens desabilitados e de conteúdo bruto são mantidos.

Em um menu, isso se aplica aos submenus. Itens de nível superior sem itens aninhados são mantidos como estão.

```php
<?php

declare(strict_types=1);

use Yiisoft\Yii\Widgets\Menu;
?>

<?= Menu::widget()
    ->pruneItems()
    ->items([
        ['label' => 'Home', 'link' => '/'],
        [
            'label' => 'Admin',
            'items' => [
                ['label' => 'Users', 'link' => '/admin/users', 'visible' => $isAdmin],
                '-',
            ],
        ],
    ]) ?>
```

## Colapsando itens em um dropdown

Quando há mais itens de nível superior do que o layout comporta, `collapseAfter()` move o excedente para um item extra
de dropdown "More" no final do menu. O valor é o número de itens de nível superior a exibir antes de colapsar;
`null` (padrão) desabilita o colapso:

```php
echo Yiisoft\Yii\Widgets\Menu::widget()
    ->collapseAfter(2)
    ->items(
        [
            ['label' => 'Home', 'link' => '/'],
            ['label' => 'About', 'link' => '/about'],
            ['label' => 'Contact', 'link' => '/contact'],
            ['label' => 'Blog', 'link' => '/blog'],
        ]
    )
    ->render();
```

O código acima gera o seguinte HTML:

```html
<ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
    <li>
        <a aria-expanded="false" data-bs-toggle="dropdown" role="button" id="dropdown-1" href="#">More</a>
        <ul aria-labelledby="dropdown-1">
            <li><a href="/contact">Contact</a></li>
            <li><a href="/blog">Blog</a></li>
        </ul>
    </li>
</ul>
```

Observações:

- apenas os itens de nível superior são colapsados; os submenus aninhados são renderizados como estão;
- o número conta apenas os itens que são de fato renderizados — itens ocultados com `visible` ou removidos por
  `filter()` e `pruneItems()` não contam, pois o colapso é aplicado depois deles;
- os itens colapsados são renderizados como itens de dropdown comuns e mantêm seus rótulos, ícones, links e submenus
  aninhados.

`collapseLabel()` altera o rótulo do botão de colapso, que é `'More'` por padrão:

```php
echo Yiisoft\Yii\Widgets\Menu::widget()
    ->collapseAfter(2)
    ->collapseLabel('Mostrar mais')
    // ...
    ->render();
```

O dropdown "More" usa a mesma configuração dos dropdowns comuns, ou seja, a de `dropdownDefinitions()`. Para estilizá-lo
de forma diferente, use `collapseDropdownDefinitions()`, que é aplicada apenas ao dropdown "More":

```php
echo Yiisoft\Yii\Widgets\Menu::widget()
    ->collapseAfter(2)
    ->collapseDropdownDefinitions(
        [
            'container()' => [false],
            'dividerClass()' => ['dropdown-divider'],
            'itemClass()' => ['dropdown-item'],
            'itemsContainerClass()' => ['dropdown-menu'],
            'toggleAttributes()' => [
                ['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown', 'role' => 'button'],
            ],
            'toggleClass()' => ['dropdown-toggle'],
            'toggleType()' => ['link'],
        ]
    )
    // ...
    ->render();
```

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe `Yiisoft\Yii\Widgets\Menu` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`activateItems(bool $value)` | Se os itens do menu pai devem ser ativados quando um dos itens do menu filho correspondente estiver ativo | `true`
`activeClass(string $value)` | A classe CSS a ser anexada ao item de menu ativo | `'active'`
`afterAttributes(array $valuesMap)` | Os atributos HTML para o contêiner posterior | `[]`
`afterClass(string $value)` | A classe CSS a ser anexada ao contêiner posterior | `''`
`afterContent(string $value)` | O conteúdo a ser anexado após o menu | `''`
`afterTag(string $value)` | O nome da tag para o contêiner posterior | `'span'`
`attributes(array $valuesMap)` | Atributos HTML para o contêiner do menu | `[]`
`beforeAttributes(array $valuesMap)` | Os atributos HTML para o contêiner anterior | `[]`
`beforeClass(string $value)` | A classe CSS a ser anexada ao contêiner anterior | `''`
`beforeContent(string $value)` | O conteúdo a ser anexado antes do menu | `''`
`beforeTag(string $value)` | O nome da tag para o contêiner anterior | `'span'`
`class(string $value)` | A classe CSS a ser anexada ao contêiner do menu | `''`
`collapseAfter(?int $value)` | O número de itens de nível superior a exibir antes de colapsar o restante em um dropdown "More", ou `null` para desabilitar o colapso. Veja [Colapsando itens em um dropdown](#colapsando-itens-em-um-dropdown) | `null`
`collapseDropdownDefinitions(?array $valuesMap)` | A configuração do widget para o dropdown "More". Quando `null`, `dropdownDefinitions()` é usada | `null`
`collapseLabel(string $value)` | O rótulo do botão do dropdown "More" | `'More'`
`container(bool $value)` | Se deve renderizar a tag do contêiner do menu | `true`
`currentPath(string $value)` | Permite atribuir o caminho atual | `''`
`disabledClass(string $value)` | A classe CSS a ser anexada ao item de menu desabilitado | `'disabled'`
`dropdownContainerClass(string $value)` | A classe CSS a ser anexada ao contêiner suspenso | `'dropdown'`
`dropdownContainerTag(string $value)` | O nome da tag para o contêiner suspenso | `'li'`
`dropdownDefinitions(array $valuesMap)` | A configuração do widget suspenso | `[]`
`filter(?Closure $callback)` | O retorno de chamada para filtrar os itens (incluindo os aninhados) antes da normalização, ou `null` para desabilitar a filtragem | `null`
`firstItemClass(string $value)` | A classe CSS do primeiro item do menu principal ou de cada submenu | `null`
`iconContainerAttributes(array $valuesMap)` | Os atributos HTML para o contêiner de ícones | `[]`
`items(array $value)` | Lista de itens do menu | `[]`
`itemsContainer(bool $value)` | Se deve renderizar a tag do contêiner de itens | `true`
`itemsContainerAttributes(array $valuesMap)` | Os atributos HTML para o contêiner de itens | `[]`
`itemsTag(string $value)` | O nome da tag para o contêiner de itens | `'li'`
`lastItemClass(string $value)` | A classe CSS do último item do menu principal ou de cada submenu | `null`
`linkAttributes(array $valuesMap)` | Os atributos HTML do link | `[]`
`linkClass(string $value)` | A classe CSS a ser anexada ao link | `''`
`linkTag(string $value)` | O nome da tag do link | `'a'`
`pruneItems(bool $value = true)` | Se deve remover submenus vazios com seus botões e divisores redundantes nos submenus após a filtragem. Veja [Removendo submenus vazios](#removendo-submenus-vazios) | `false`
`template(string $value)` | O modelo usado para renderizar o menu principal | `'{items}'`

### A estrutura de itens é um array com a seguinte estrutura

```php
[
    [
        'label' => '',
        'active' => false,
        'disabled' => false,
        'encode' => true,
        'items' => [],
        'itemsContainerAttributes' => [],
        'link' => '',
        'linkAttributes' => [],
        'icon' => '',
        'iconAttributes' => [],
        'iconClass' => '',
        'itemsContainerAttributes' => [],
        'visible' => true,
    ],
]
```
