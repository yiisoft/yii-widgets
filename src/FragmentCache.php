<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use RuntimeException;
use Yiisoft\Cache\CacheInterface;
use Yiisoft\Cache\Dependency\Dependency;
use Yiisoft\View\Cache\CachedContent;
use Yiisoft\View\Cache\DynamicContent;
use Yiisoft\Widget\Widget;

use function ob_end_clean;
use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;

/**
 * FragmentCache caches a fragment of content.
 *
 * @see CachedContent
 * @see DynamicContent
 *
 * Example of use:
 *
 * ```php
 * $dynamicContent = new Yiisoft\View\Cache\DynamicContent('dynamic-id', static function (array $parameters): string {
 *     return strtoupper("{$parameters['a']} - {$parameters['b']}");
 * }, ['a' => 'string-a', 'b' => 'string-b']);
 *
 * FragmentCache::widget()->id('cache-id')->ttl(30)->dynamicContents($dynamicContent)->begin();
 *     echo 'Content to be cached ...';
 *     echo $dynamicContent->placeholder();
 *     echo 'Content to be cached ...';
 * FragmentCache::end();
 * ```
 */
final class FragmentCache extends Widget
{
    private ?string $id = null;
    private CacheInterface $cache;
    private ?Dependency $dependency = null;
    private int $ttl = 60;
    private array $variations = [];

    /**
     * @var array<string, DynamicContent>
     */
    private array $dynamicContents = [];

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Initializes the FragmentCache object.
     */
    public function begin(): ?string
    {
        parent::begin();
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
        return null;
    }

    /**
     * Marks the end of content to be cached.
     *
     * Content displayed before this method call and after {@see init()} will be captured and saved in cache.
     *
     * This method does nothing if valid content is already found in cache.
     *
     * @return string The result of widget execution to be outputted.
     */
    protected function run(): string
    {
        if ($this->id === null) {
            ob_end_clean();
            throw new RuntimeException('You must assign the "id" using the "id()" setter.');
        }

        $cachedContent = new CachedContent($this->id, $this->cache, $this->dynamicContents, $this->variations);
        $content = $cachedContent->get();

        if ($content !== null) {
            ob_end_clean();
            return $content;
        }

        $content = ob_get_clean();

        if ($content === false || $content === '') {
            return '';
        }

        return $cachedContent->cache($content, $this->ttl, $this->dependency);
    }

    /**
     * @param string $value The unique identifier of the cache fragment.
     *
     * @return self
     */
    public function id(string $value): self
    {
        $this->id = $value;
        return $this;
    }

    /**
     * @param Dependency $value The dependency that the cached content depends on.
     *
     * This can be either a {@see Dependency} object or a configuration array for creating the dependency object.
     *
     * Would make the output cache depends on the last modified time of all posts. If any post has its modification time
     * changed, the cached content would be invalidated.
     *
     * @return self
     */
    public function dependency(Dependency $value): self
    {
        $this->dependency = $value;
        return $this;
    }

    /**
     * @param int $value The number of seconds that the data can remain valid in cache.
     *
     * @return self
     */
    public function ttl(int $value): self
    {
        $this->ttl = $value;
        return $this;
    }

    /**
     * @param DynamicContent ...$value The dynamic content instances.
     *
     * @return self
     */
    public function dynamicContents(DynamicContent ...$value): self
    {
        foreach ($value as $dynamicContent) {
            $this->dynamicContents[$dynamicContent->id()] = $dynamicContent;
        }
        return $this;
    }

    /**
     * @param string ...$value The factors that would cause the variation of the content being cached.
     *
     * Each factor is a string representing a variation (e.g. the language, a GET parameter). The following variation
     * setting will cause the content to be cached in different versions according to the current application language:
     *
     * ```php
     * $fragmentCache->variations('en');
     * ```
     *
     * @return self
     */
    public function variations(string ...$value): self
    {
        $this->variations = $value;
        return $this;
    }
}
