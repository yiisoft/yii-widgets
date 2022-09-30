<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\ContentDecorator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Yii\Widgets\ContentDecorator;
use Yiisoft\Yii\Widgets\Tests\Support\Assert;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ContentDecoratorTest extends TestCase
{
    use TestTrait;

    /**
     * @link https://github.com/yiisoft/yii2/issues/15536
     *
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testContentDecorator(): void
    {
        ContentDecorator::widget()->viewFile('@public/view/layout.php')->begin();
        echo "<div class='left-column'>\n";
        echo "<p>This is a left bar!</p>\n";
        echo "</div>\n";
        echo "<div class='right-column'>\n";
        echo "<p>This is a right bar!</p>\n";
        echo '</div>';
        $html = ContentDecorator::end();

        $this->assertStringContainsString('<title>Test</title>', $html);

        Assert::equalsWithoutLE(
            <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>Test</title>
                </head>
            <body>

            <div class='left-column'>
            <p>This is a left bar!</p>
            </div>
            <div class='right-column'>
            <p>This is a right bar!</p>
            </div>
            </body>
            </html>

            HTML,
            $html,
        );
    }
}
