<?php

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\FragmentCache;

use function array_merge;
use function md5;
use function sha1;
use function vsprintf;

final class FragmentCacheTest extends TestCase
{
    public function testCacheEnabled(): void
    {
        FragmentCache::begin()
            ->id('test')
            ->start();

        echo 'cached fragment';

        $html = FragmentCache::end();

        $this->assertEquals('cached fragment', $html);
    }

    public function testSingleDynamicFragment(): void
    {
        $params = '0';

        for ($counter = 0; $counter < 42; $counter++) {
            $html = FragmentCache::begin()->id('test');

            if ($html->getCachedContent() === null) {
                $html->start();
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
            $html = FragmentCache::begin()->id('test');

            if ($html->getCachedContent() === null) {
                $html->start();
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
            $html1 = FragmentCache::begin()->id('test');

            if ($html1->getCachedContent() === null) {
                $html1->start();
                echo 'nested dynamic cached fragments: ';
                echo $this->webView->renderDynamic('return md5($counter);', ['counter' => $params]);
            }

            $html = FragmentCache::end();

            $html2 = FragmentCache::begin()->id('test-nested');

            if ($html2->getCachedContent() === null) {
                $html2->start();
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

        $key = array_merge([FragmentCache::class, 'test'], ['variations' => ['ru']]);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        $html1 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html1);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->start();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');

        $html2 = FragmentCache::end();

        $this->assertEquals($html1, $html2);

        $key = array_merge([FragmentCache::class, 'test'], ['variations' => ['en']]);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['en']])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        FragmentCache::end();

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['en']])
            ->start();

        FragmentCache::end();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');

        /** without variations */
        $key = [FragmentCache::class, 'test'];

        FragmentCache::begin()
            ->id('test')
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        $html3 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html3);

        /**  with variations as a string */
        $key = array_merge([FragmentCache::class, 'test'], ['variations' => 'uz']);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        $html4 = FragmentCache::end();

        $this->assertEquals('cached fragment', $html4);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->start();

        $html5 = FragmentCache::end();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');
        $this->assertEquals($html4, $html5);
    }
}
