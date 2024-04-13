# Widget decorador de conteúdo

Este widget registra todas as saídas entre as chamadas `begin()` e `end()`, passando-as para o
visualizador do arquivo como `$content` e então reproduz o resultado da renderização.

Para obter mais informações sobre renderização da visualização
[veja aqui](https://github.com/yiisoft/view/blob/master/docs/basic-functionality.md#rendering).

## Uso

```php
use Yiisoft\Yii\Widgets\ContentDecorator;

ContentDecorator::widget()
    ->parameters(['name' => 'value'])
    ->viewFile('@app/views/layouts/main.php')
    ->begin();

echo 'Some content here.';

ContentDecorator::end();
```

Observe que o alias do caminho é passado para o método `viewFile()`. Você pode especificar
o caminho absoluto para o arquivo de visualização ou seu alias. Para obter mais informações sobre aliases,
veja a descrição do pacote [yiisoft/aliases](https://github.com/yiisoft/aliases).

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe
`Yiisoft\Yii\Widgets\ContentDecorator` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`parameters(array $value)` | Os parâmetros (nome => valor) a serem extraídos e disponibilizados na vista decorativa | `[]`
`viewFile(string $value)` | O arquivo de visualização que será usado para decorar o conteúdo incluído neste widget | `''`
