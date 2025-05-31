<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets\Tests\FragmentCache;

use PHPUnit\Framework\TestCase;
use Yiisoft\Cache\CacheKeyNormalizer;
use Yiisoft\Cache\Dependency\TagDependency;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\View\Cache\CachedContent;
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Yii\Widgets\FragmentCache;
use Yiisoft\Yii\Widgets\Tests\Support\TestTrait;

use function array_merge;
use function md5;
use function sha1;
use function sprintf;

final class FragmentCacheTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testCacheFragment(): void
    {
        FragmentCache::widget()->dependency(new TagDependency('test'))->id('test')->ttl(30)->begin();
        echo 'cached fragment';
        $content = FragmentCache::end();

        $this->assertSame('cached fragment', $content);
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testCacheFragmentWithEmptyContent(): void
    {
        FragmentCache::widget()->id('test')->ttl(30)->begin();
        $content = FragmentCache::end();

        $this->assertEmpty($content);
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testSingleDynamicFragment(): void
    {
        for ($counter = 0; $counter < 42; $counter++) {
            $dynamicContent = new DynamicContent(
                'dynamic-test',
                static fn ($params) => (string) $params['counter'],
                ['counter' => $counter],
            );

            FragmentCache::widget()->dynamicContents($dynamicContent)->id('test')->begin();
            echo 'single dynamic cached fragment: ';
            echo $dynamicContent->placeholder();
            $content = FragmentCache::end();

            $expectedContent = sprintf('single dynamic cached fragment: %d', $counter);

            $this->assertSame($expectedContent, $content);
        }
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testMultipleDynamicFragments(): void
    {
        for ($counter = 0; $counter < 42; $counter++) {
            $dynamicContent1 = new DynamicContent(
                'dynamic-test-1',
                static fn ($params) => md5((string) $params['counter']),
                ['counter' => $counter],
            );
            $dynamicContent2 = new DynamicContent(
                'dynamic-test-2',
                static fn ($params) => (string) $params['counter'],
                ['counter' => $counter],
            );

            FragmentCache::widget()
                ->dynamicContents($dynamicContent1)
                ->dynamicContents($dynamicContent2)
                ->id('test')
                ->begin()
            ;
            echo 'multiple dynamic cached fragments: ';
            echo $dynamicContent1->placeholder();
            echo $dynamicContent2->placeholder();
            $content = FragmentCache::end();

            $expectedContent = sprintf(
                'multiple dynamic cached fragments: %s%d',
                md5((string) $counter),
                $counter,
            );

            $this->assertSame($expectedContent, $content);
        }
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testNestedDynamicFragments(): void
    {
        for ($counter = 0; $counter < 42; $counter++) {
            $dynamicContent1 = new DynamicContent(
                'dynamic-test-1',
                static fn ($params) => md5((string) $params['counter']),
                ['counter' => $counter],
            );
            $dynamicContent2 = new DynamicContent(
                'dynamic-test-2',
                static fn ($params) => sha1((string) $params['counter']),
                ['counter' => $counter],
            );
            $dynamicContent3 = new DynamicContent(
                'dynamic-test-3',
                static fn ($params) => (string) ($params['counter'] + 1),
                ['counter' => $counter],
            );

            FragmentCache::widget()->dynamicContents($dynamicContent1)->id('test')->begin();
            echo 'nested dynamic cached fragments: ';
            echo $dynamicContent1->placeholder();
            $content = FragmentCache::end();

            FragmentCache::widget()
                ->dynamicContents($dynamicContent2)
                ->dynamicContents($dynamicContent3)
                ->id('test-nested')
                ->begin()
            ;
            echo $dynamicContent2->placeholder();
            echo $dynamicContent3->placeholder();
            $content .= FragmentCache::end();

            $expectedContent = sprintf(
                'nested dynamic cached fragments: %s%s%d',
                md5((string) $counter),
                sha1((string) $counter),
                $counter + 1,
            );


            $this->assertSame($expectedContent, $content);
        }
    }

    /**
     * @throws CircularReferenceException
     * @throws InvalidConfigException
     * @throws NotFoundException
     * @throws NotInstantiableException
     */
    public function testVariations(): void
    {
        $this->setOutputCallback(static fn () => null);

        FragmentCache::widget()->id($id = 'test')->variations($variation = 'ru')->begin();
        echo 'cached fragment';

        $this->assertFalse($this->hasCache($id, $variation), 'Cached fragment should not be exist');

        $content1 = FragmentCache::end();

        $this->assertSame('cached fragment', $content1);

        FragmentCache::widget()->id($id = 'test')->variations($variation = 'ru')->begin();

        $this->assertTrue($this->hasCache($id, $variation), 'Cached fragment should be exist');

        $content2 = FragmentCache::end();

        $this->assertSame($content1, $content2);

        FragmentCache::widget()->id($id = 'test')->variations($variation = 'en')->begin();
        echo 'cached fragment';

        $this->assertFalse($this->hasCache($id, $variation), 'Cached fragment should not be exist');

        FragmentCache::end();

        $this->assertTrue($this->hasCache($id, $variation), 'Cached fragment should not be exist');

        /** without variations */
        FragmentCache::widget()->id($id = 'test')->begin();
        echo 'cached fragment';

        $this->assertFalse($this->hasCache($id), 'Cached fragment should not be exist');

        $content4 = FragmentCache::end();

        $this->assertSame('cached fragment', $content4);
    }

    private function hasCache(string $id, ?string $variation = null): bool
    {
        $key = (new CacheKeyNormalizer())->normalize(
            array_merge([CachedContent::class, $id], (array) ($variation ?? []))
        );

        return $this->cache->psr()->has($key);
    }
}
