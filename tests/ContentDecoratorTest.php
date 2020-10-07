<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\ContentDecorator;

/**
 * ContentDecoratorTest.
 */
final class ContentDecoratorTest extends TestCase
{
    /**
     * {@see https://github.com/yiisoft/yii2/issues/15536}
     */
    public function testContentDecorator(): void
    {
        ContentDecorator::begin()
            ->viewFile($this->aliases->get('@public/view/layout.php'))
            ->params([])
            ->start();

        echo "\t\t<div class='left-column'>\n";
        echo "\t\t\t<p>This is a left bar!</p>\n";
        echo "\t\t</div>\n\n";
        echo "\t\t<div class='right-column'>\n";
        echo "\t\t\t<p>This is a right bar!</p>\n";
        echo "\t\t</div>\n";

        $html = ContentDecorator::end();

        $expected = "\t\t<div class='left-column'>\n" .
                    "\t\t\t<p>This is a left bar!</p>\n" .
                    "\t\t</div>\n\n" .
                    "\t\t<div class='right-column'>\n" .
                    "\t\t\t<p>This is a right bar!</p>\n" .
                    "\t\t</div>\n";

        $this->assertStringContainsString($expected, $html);
    }
}
