<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\Spaceless;

/**
 * SpacelessTest.
 */
class SpacelessTest extends TestCase
{
    public function testWidget(): void
    {
        ob_start();
        ob_implicit_flush(0);

        echo "<body>\n";

        Spaceless::begin()->init();
        echo "\t<div class='wrapper'>\n";

        Spaceless::begin()->init();
        echo "\t\t<div class='left-column'>\n";
        echo "\t\t\t<p>This is a left bar!</p>\n";
        echo "\t\t</div>\n\n";
        echo "\t\t<div class='right-column'>\n";
        echo "\t\t\t<p>This is a right bar!</p>\n";
        echo "\t\t</div>\n";
        echo Spaceless::end();

        echo "\t</div>\n";
        echo Spaceless::end();

        echo "\t<p>Bye!</p>\n";
        echo "</body>\n";

        $expected = "<body>\n<div class='wrapper'><div class='left-column'><p>This is a left bar!</p>".
            "</div><div class='right-column'><p>This is a right bar!</p></div></div>\t<p>Bye!</p>\n</body>\n";
            
        $this->assertEquals($expected, ob_get_clean());
    }
}
