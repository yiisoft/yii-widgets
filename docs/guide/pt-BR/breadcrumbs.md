# Widget Breadcrumbs (Widget da localização atual)

Este widget é um componente de navegação simples.

Observe que o widget renderiza apenas as tags HTML sobre a localização atual. Ele faz qualquer estilo.
Você é responsável por fornecer estilos CSS para fazer com que pareça uma verdadeira localização atual.

## Uso

```php
use Yiisoft\Yii\Widgets\Breadcrumbs;

echo Breadcrumbs::widget()
    ->homeItem([
        'label' => 'Home',
        'url' => 'site/index',
        'class' => 'home',
    ])
    ->items([
        [
            'label' => 'Category',
            'url' => 'site/category',
            'class' => 'category',
        ],
        [
            'label' => 'Item',
            'url' => 'site/category/item',
            'class' => 'item',
        ],
    ])
    ->render();
```

O código acima gera o seguinte HTML:

```html
<ul class="breadcrumbs">
    <li><a class="home" href="site/index">Home</a></li>
    <li><a class="category" href="site/category">Category</a></li>
    <li><a class="item" href="site/category/item">Item</a></li>
</ul>
```

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe `Yiisoft\Yii\Widgets\Breadcrumbs`
com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`activeItemTemplate(string $value)`| Modelo usado para renderizar cada item ativo na localização atual | `"<li class=\"active\">{link}</li>\n"`
`attributes(array $valuesMap)` | Atributos HTML para o contêiner de localização atual | `[]`
`homeItem(?array $value)` | O primeiro item na localização atual (chamado link inicial) | `['label' => 'Home', 'url' => '/']`
`items(array $value)` | Lista de itens que aparecerão na localização atual | `[]`
`itemTemplate(string $value)` | Modelo usado para renderizar cada item inativo na localização atual | `"<li>{link}</li>\n"`
`tag(string $value)` | O nome da tag do contêiner | `'ul'`
