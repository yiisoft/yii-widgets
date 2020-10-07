<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Yiisoft\Cache\CacheInterface;
use Yiisoft\Cache\Dependency\Dependency;
use Yiisoft\View\DynamicContentAwareInterface;
use Yiisoft\View\DynamicContentAwareTrait;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

use function array_merge;
use function ob_get_clean;
use function ob_implicit_flush;
use function ob_start;

/**
 * FragmentCache is used by {@see \Yiisoft\View\View} to provide caching of page fragments.
 *
 * @property-read string|false $cachedContent The cached content. False is returned if valid content is not found in the
 * cache. This property is read-only.
 */
final class FragmentCache extends Widget implements DynamicContentAwareInterface
{
    use DynamicContentAwareTrait;

    private string $id;

    /**
     * @var CacheInterface|null the cache object or the application component ID of the cache object.
     *
     * After the FragmentCache object is created, if you want to change this property, you should only assign it with
     * a cache object.
     */
    private CacheInterface $cache;

    /**
     * @var int number of seconds that the data can remain valid in cache.
     *
     * Use 0 to indicate that the cached data will never expire.
     */
    private int $duration = 60;

    /**
     * @var Dependency|null the dependency that the cached content depends on.
     *
     * This can be either a {@see Dependency} object or a configuration array for creating the dependency object.
     *
     * Would make the output cache depends on the last modified time of all posts. If any post has its modification time
     * changed, the cached content would be invalidated.
     */
    private ?Dependency $dependency = null;

    /**
     * @var string[]|string list of factors that would cause the variation of the content being cached.
     *
     * Each factor is a string representing a variation (e.g. the language, a GET parameter). The following variation
     * setting will cause the content to be cached in different versions according to the current application language:
     */
    private $variations;

    /**
     * @var string|null the cached content. Null if the content is not cached.
     */
    private ?string $content = null;

    private WebView $webView;

    public function __construct(CacheInterface $cache, WebView $webview)
    {
        $this->cache = $cache;
        $this->webView = $webview;
    }

    /**
     * Initializes the FragmentCache object.
     */
    public function start(): void
    {
        if ($this->getCachedContent() === null) {
            $this->webView->pushDynamicContent($this);
            ob_start();
            PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
        }
    }

    /**
     * Marks the end of content to be cached.
     *
     * Content displayed before this method call and after {@see init()} will be captured and saved in cache.
     *
     * This method does nothing if valid content is already found in cache.
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run(): string
    {
        if (($content = $this->getCachedContent()) !== null) {
            return $content;
        }

        $this->webView->popDynamicContent();

        $content = ob_get_clean();

        if ($content === false || $content === '') {
            return '';
        }

        $data = [$content, $this->getDynamicPlaceholders()];
        $this->cache->set($this->calculateKey(), $data, $this->duration, $this->dependency);

        return $this->updateDynamicContent($content, $this->getDynamicPlaceholders());
    }

    /**
     * Returns the cached content if available.
     *
     * @return string|null the cached content. False is returned if valid content is not found in the cache.
     */
    public function getCachedContent(): ?string
    {
        $key = $this->calculateKey();

        if (!$this->cache->has($key)) {
            return null;
        }

        $data = $this->cache->get($key);

        [$this->content, $placeholders] = $data;

        $this->content = $this->updateDynamicContent($this->content, $placeholders, true);

        return $this->content;
    }

    /**
     * Generates a unique key used for storing the content in cache.
     *
     * The key generated depends on both {@see id} and {@see variations}.
     *
     * @return mixed a valid cache key
     */
    public function calculateKey()
    {
        return array_merge([__CLASS__, $this->id], (array) $this->variations);
    }

    /**
     * {@see $content}
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function content(?string $value): self
    {
        $this->content = $value;

        return $this;
    }

    /**
     * {@see $dependency}
     *
     * @param Dependency $value
     *
     * @return $this
     */
    public function dependency(Dependency $value): self
    {
        $this->dependency = $value;

        return $this;
    }

    /**
     * {@see $duration}
     *
     * @param int $value
     *
     * @return $this
     */
    public function duration(int $value): self
    {
        $this->duration = $value;

        return $this;
    }

    /**
     * @see $id
     *
     * @param string $value
     *
     * @return $this
     */
    public function id(string $value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * {@see $variations}
     *
     * @param array|string $value
     *
     * @return $this
     */
    public function variations($value): self
    {
        $this->variations = $value;

        return $this;
    }

    protected function getView(): WebView
    {
        return $this->webView;
    }
}
