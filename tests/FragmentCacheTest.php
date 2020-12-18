<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests;

use ReflectionClass;
use Yiisoft\Yii\Widgets\FragmentCache;

use function md5;
use function sha1;
use function vsprintf;

final class FragmentCacheTest extends TestCase
{
    public function testCacheEnabled(): void
    {
        FragmentCache::widget()
            ->id('test')
            ->begin();

        echo 'cached fragment';

        $html = FragmentCache::end();

        $this->assertEquals('cached fragment', $html);
    }

    public function testSingleDynamicFragment(): void
    {
        $params = '0';

        for ($counter = 0; $counter < 42; $counter++) {
            $html = FragmentCache::widget()->id('test');

            $html->begin();
            if ($html->getCachedContent() === null) {
                echo 'single dynamic cached fragment: ';
                echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);
            }

            $html = FragmentCache::end();


            $expectedContent = vsprintf('single dynamic cached fragment: %d', [
                $params,
            ]);

            $this->assertEquals($expectedContent, $html);
        }
    }

    public function testMultipleDynamicFragments(): void
    {
        $params = '0';

        for ($counter = 0; $counter < 42; $counter++) {
            $html = FragmentCache::widget()->id('test');
            $html->begin();

            if ($html->getCachedContent() === null) {
                echo 'multiple dynamic cached fragments: ';
                echo $this->webView->renderDynamic('return md5($counter);', ['counter' => $params]);
                echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);
            }

            $html = FragmentCache::end();

            $expectedContent = vsprintf('multiple dynamic cached fragments: %s%d', [
                md5($params),
                $params,
            ]);

            $this->assertEquals($expectedContent, $html);
        }
    }

    public function testNestedDynamicFragments(): void
    {
        $params = '0';

        for ($counter = 0; $counter < 42; $counter++) {
            $html1 = FragmentCache::widget()->id('test');
            $html1->begin();

            if ($html1->getCachedContent() === null) {
                echo 'nested dynamic cached fragments: ';
                echo $this->webView->renderDynamic('return md5($counter);', ['counter' => $params]);
            }

            $html = FragmentCache::end();

            $html2 = FragmentCache::widget()->id('test-nested');
            $html2->begin();

            if ($html2->getCachedContent() === null) {
                echo $this->webView->renderDynamic('return sha1($counter);', ['counter' => $params]);
                echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);
            }

            $html .= FragmentCache::end();

            $expectedContent = vsprintf('nested dynamic cached fragments: %s%s%d', [
                md5($params),
                sha1($params),
                $params,
            ]);


            $this->assertEquals($expectedContent, $html);
        }
    }

    public function testVariations(): void
    {
        $this->setOutputCallback(static function () {
            return null;
        });

        $widget1 = FragmentCache::widget();

        $widget1
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->begin();

        echo 'cached fragment';

        $this->assertFalse($this->hasCache($widget1->calculateKey()), 'Cached fragment should not be exist');

        $html1 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html1);

        $widget2 = FragmentCache::widget();

        $widget2
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->begin();

        $this->assertTrue($this->hasCache($widget2->calculateKey()), 'Cached fragment should be exist');

        $html2 = FragmentCache::end();

        $this->assertEquals($html1, $html2);

        $widget3 = FragmentCache::widget();

        $widget3
            ->id('test')
            ->variations(['variations' => ['en']])
            ->begin();

        echo 'cached fragment';

        $this->assertFalse($this->hasCache($widget3->calculateKey()), 'Cached fragment should not be exist');

        FragmentCache::end();

        $widget4 = FragmentCache::widget();

        $widget4
            ->id('test')
            ->variations(['variations' => ['en']])
            ->begin();

        FragmentCache::end();

        $this->assertTrue($this->hasCache($widget4->calculateKey()), 'Cached fragment should be exist');

        /** without variations */
        $widget5 = FragmentCache::widget();

        $widget5
            ->id('test')
            ->begin();

        echo 'cached fragment';

        $this->assertFalse($this->hasCache($widget5->calculateKey()), 'Cached fragment should not be exist');

        $html3 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html3);

        /**  with variations as a string */
        $widget6 = FragmentCache::widget();

        $widget6
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->begin();

        echo 'cached fragment';

        $this->assertFalse($this->hasCache($widget6->calculateKey()), 'Cached fragment should not be exist');

        $html4 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html4);

        $widget7 = FragmentCache::widget();

        $widget7
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->begin();

        $html5 = FragmentCache::end();

        $this->assertTrue($this->hasCache($widget7->calculateKey()), 'Cached fragment should be exist');
        $this->assertEquals($html4, $html5);
    }

    private function hasCache(string $key): bool
    {
        return $this->cache->psr()->has($key);
    }
}
