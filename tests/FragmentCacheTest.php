<?php

namespace Yiisoft\Yii\Widgets\Tests;

use Yiisoft\Yii\Widgets\FragmentCache;

final class FragmentCacheTest extends TestCase
{
    public function testCacheEnabled(): void
    {
        ob_start();
        ob_implicit_flush(false);

        FragmentCache::begin()
            ->id('test')
            ->start();

        echo 'cached fragment';

        echo FragmentCache::end();

        $this->assertEquals('cached fragment', ob_get_clean());
    }

    public function testCacheDisabled1()
    {
        $expectedLevel = ob_get_level();

        ob_start();
        ob_implicit_flush(0);

        $key = array_merge([FragmentCache::class, 'test']);

        FragmentCache::begin()
            ->id('test')
            ->cache(null)
            ->start();

        echo 'cached fragment';

        echo FragmentCache::end();

        $this->assertFalse($this->cache->has($key));
        $this->assertEquals('cached fragment', ob_get_clean());

        ob_end_clean();

        $this->assertEquals($expectedLevel, ob_get_level(), 'Output buffer not closed correctly.');
    }

    public function testCacheDisabled2()
    {
        $expectedLevel = ob_get_level();

        ob_start();
        ob_implicit_flush(0);

        $key = array_merge([FragmentCache::class, 'test']);

        FragmentCache::begin()
            ->id('test')
            ->start();

        echo 'cached fragment';

        echo FragmentCache::end();

        $this->assertTrue($this->cache->has($key));
        $this->assertEquals('cached fragment', ob_get_clean());

        ob_start();
        ob_implicit_flush(0);

        FragmentCache::begin()
            ->id('test')
            ->cache(null)
            ->start();

        echo 'cached fragment other';

        echo FragmentCache::end();

        $this->assertEquals('cached fragment other', ob_get_clean());

        ob_end_clean();

        $this->assertEquals($expectedLevel, ob_get_level(), 'Output buffer not closed correctly.');
    }

    public function testSingleDynamicFragment()
    {
        $params = 0;

        for ($counter = 0; $counter < 42; $counter++) {
            ob_start();
            ob_implicit_flush(0);

            FragmentCache::begin()->id('test')->start();

            echo 'single dynamic cached fragment: ';
            echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);

            echo FragmentCache::end();


            $expectedContent = vsprintf('single dynamic cached fragment: %d', [
                $params,
            ]);

            $this->assertEquals($expectedContent, ob_get_clean());
        }
    }

    public function testMultipleDynamicFragments()
    {
        $params = 0;

        for ($counter = 0; $counter < 42; $counter++) {
            ob_start();
            ob_implicit_flush(0);

            FragmentCache::begin()->id('test')->start();

            echo 'multiple dynamic cached fragments: ';
            echo $this->webView->renderDynamic('return md5($counter);', ['counter' => $params]);
            echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);

            echo FragmentCache::end();

            $expectedContent = vsprintf('multiple dynamic cached fragments: %s%d', [
                md5($params),
                $params,
            ]);

            $this->assertEquals($expectedContent, ob_get_clean());
        }
    }

    public function testNestedDynamicFragments()
    {
        $params = 0;

        for ($counter = 0; $counter < 42; $counter++) {
            ob_start();
            ob_implicit_flush(false);

            FragmentCache::begin()->id('test')->start();

            echo 'nested dynamic cached fragments: ';
            echo $this->webView->renderDynamic('return md5($counter);', ['counter' => $params]);

            FragmentCache::begin()->id('test-nested')->start();
            echo $this->webView->renderDynamic('return sha1($counter);', ['counter' => $params]);
            echo FragmentCache::end();

            echo $this->webView->renderDynamic('return $counter++;', ['counter' => $params]);

            echo FragmentCache::end();

            $expectedContent = vsprintf('nested dynamic cached fragments: %s%s%d', [
                md5($params),
                sha1($params),
                $params,
            ]);

            $this->assertEquals($expectedContent, ob_get_clean());
        }
    }

    public function testVariations()
    {
        $this->setOutputCallback(static function ($output) {
            return null;
        });

        ob_start();
        ob_implicit_flush(0);

        $key = array_merge([FragmentCache::class, 'test'], ['variations' => ['ru']]);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        echo FragmentCache::end();

        $cached = ob_get_clean();
        $this->assertEquals('cached fragment', $cached);

        ob_start();
        ob_implicit_flush(0);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['ru']])
            ->content(null)
            ->start();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');

        echo FragmentCache::end();

        $this->assertEquals($cached, ob_get_clean());

        $key = array_merge([FragmentCache::class, 'test'], ['variations' => ['en']]);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['en']])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        echo FragmentCache::end();

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => ['en']])
            ->content(null)
            ->start();

        echo FragmentCache::end();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');

        //without variations
        ob_start();
        ob_implicit_flush(false);

        $key = [FragmentCache::class, 'test'];

        FragmentCache::begin()
            ->id('test')
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        echo FragmentCache::end();

        $this->assertEquals('cached fragment', ob_get_clean());

        //with variations as a string
        ob_start();
        ob_implicit_flush(0);

        $key = array_merge([FragmentCache::class, 'test'], ['variations' => 'uz']);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->start();

        echo 'cached fragment';

        $this->assertFalse($this->cache->has($key), 'Cached fragment should not be exist');

        echo FragmentCache::end();

        $cached = ob_get_clean();
        $this->assertEquals('cached fragment', $cached);

        ob_start();
        ob_implicit_flush(0);

        FragmentCache::begin()
            ->id('test')
            ->variations(['variations' => 'uz'])
            ->content(null)
            ->start();
        echo FragmentCache::end();

        $this->assertTrue($this->cache->has($key), 'Cached fragment should be exist');
        $this->assertEquals($cached, ob_get_clean());
    }
}
