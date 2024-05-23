# Widget de cache de fragmentos

Em alguns casos, armazenar fragmentos de conteúdo em cache pode melhorar significativamente o desempenho do seu aplicativo. Por exemplo,
se uma página exibir um resumo das vendas anuais em uma tabela, você poderá armazenar essa tabela em um cache para eliminar o tempo
necessário para gerar esta tabela para cada solicitação.

Para obter mais informações sobre cache de conteúdo [veja aqui](https://github.com/yiisoft/view/blob/master/docs/guide/en/basic-functionality.md#content-caching).

## Uso

```php
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Yii\Widgets\FragmentCache;

// Creating a dynamic content instance
$dynamicContent = new DynamicContent(
    'dynamic-id',
    static function (array $parameters): string {
        return strtoupper("{$parameters['a']} - {$parameters['b']}");
    },
    ['a' => 'string-a', 'b' => 'string-b'],
);

// We use the widget as a wrapper over the content that should be cached:
FragmentCache::widget()
    ->id('cache-id')
    ->dynamicContents($dynamicContent)
    ->begin();
    echo "Content to be cached ...\n";
    echo $dynamicContent->placeholder();
    echo "\nContent to be cached ...\n";
FragmentCache::end();
```

O código acima gera o seguinte HTML:

```text
Content to be cached ...
STRING-A - STRING-B
Content to be cached ...
```

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da
classe `Yiisoft\Yii\Widgets\FragmentCache` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`dynamicContents(DynamicContent ...$value)` | As instâncias de conteúdo dinâmico | `null`
`id(string $value)` | O identificador exclusivo do fragmento de cache | `''`
`ttl(int $value)` | O número de segundos que os dados podem permanecer válidos no cache | `60`
`variations(string ...$value)` | Os fatores que causariam a variação do conteúdo armazenado em cache | `[]`
