# Widget Block

Imagine que uma determinada parte dos layouts deva mudar dependendo do conteúdo da visualização.
Um mecanismo de "blocks" é fornecido para transmitir tais pedaços.

Para obter mais informações sobre o compartilhamento de dados entre visualizações,
[veja aqui](https://github.com/yiisoft/view/blob/master/docs/guide/en/basic-functionality.md#sharing-data-among-views).

## Uso

A ideia geral é que você esteja definindo o bloco padrão em uma visualização ou layout:

```php
use Yiisoft\Yii\Widgets\Block;

Block::widget()
    ->id('my-block')
    ->begin();
    echo 'Nothing.';
Block::end();
```

E então redefinindo o valor padrão nas visualizações:

```php
use Yiisoft\Yii\Widgets\Block;

Block::widget()
    ->id('my-block')
    ->begin();
    echo 'Umm... hello?';
Block::end();
```

Na subespécie, mostre o bloco:

```php
/**
 * @var Yiisoft\View\WebView $this
 */

echo $this->getBlock('my-block');
```

## Setters (Configuradores)

Todos os setters são imutáveis e retornam uma nova instância da classe `Yiisoft\Yii\Widgets\Block` com o valor especificado.

Método | Descrição | Padrão
-------|-------------|---------
`id(string $valor)` | O identificador exclusivo do bloco | `''`
`renderInPlace()` | Ativa a renderização local do conteúdo do bloco | `false`
