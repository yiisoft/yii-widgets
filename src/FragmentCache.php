<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Widgets;

use Yiisoft\Cache\CacheInterface;
use Yiisoft\Cache\Dependency\Dependency;
use Yiisoft\View\DynamicContentAwareInterface;
use Yiisoft\View\DynamicContentAwareTrait;
use Yiisoft\View\View;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

/**
 * FragmentCache is used by {@see \Yiisoft\View\View} to provide caching of page fragments.
 *
 * @property-read string|false $cachedContent The cached content. False is returned if valid content is not found in the
 * cache. This property is read-only.
 */
class FragmentCache extends Widget implements DynamicContentAwareInterface
{
    use DynamicContentAwareTrait;

    private string $id;

    /**
     * @var CacheInterface|null the cache object or the application component ID of the cache object.
     *
     * After the FragmentCache object is created, if you want to change this property, you should only assign it with
     * a cache object.
     */
    private ?CacheInterface $cache = null;

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
     * @var string|bool the cached content. Null if the content is not cached.
     */
    private $content = false;

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
        if ($this->getCachedContent() === false) {
            $this->webView->pushDynamicContent($this);
            ob_start();
            ob_implicit_flush(0);
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
        if (($content = $this->getCachedContent()) !== false) {
            return $content;
        }

        if ($this->cache instanceof CacheInterface) {
            $this->webView->popDynamicContent();

            $content = ob_get_clean();

            if ($content === false || $content === '') {
                return '';
            }

            $data = [$content, $this->getDynamicPlaceholders()];
            $this->cache->set($this->calculateKey(), $data, $this->duration, $this->dependency);

            return $this->updateDynamicContent($content, $this->getDynamicPlaceholders());
        }

        return '';
    }

    /**
     * Returns the cached content if available.
     *
     * @return string|false the cached content. False is returned if valid content is not found in the cache.
     */
    public function getCachedContent()
    {
        if ($this->content !== null) {
            return $this->content;
        }

        if (!($this->cache instanceof CacheInterface)) {
            return $this->content;
        }

        $key = $this->calculateKey();
        $data = $this->cache->get($key);

        if (!\is_array($data) || count($data) !== 2) {
            return $this->content;
        }

        [$this->content, $placeholders] = $data;

        if (!\is_array($placeholders) || count($placeholders) === 0) {
            return $this->content;
        }

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
     * {@see $cache}
     *
     * @param CacheInterface|null $value
     *
     * @return FragmentCache
     */
    public function cache(?CacheInterface $value): FragmentCache
    {
        $this->cache = $value;

        return $this;
    }

    /**
     * {@see $content}
     *
     * @param string|bool $value
     *
     * @return FragmentCache
     */
    public function content($value): FragmentCache
    {
        $this->content = $value;

        return $this;
    }

    /**
     * {@see $dependency}
     *
     * @param Dependency $value
     *
     * @return FragmentCache
     */
    public function dependency(Dependency $value): FragmentCache
    {
        $this->dependency = $value;

        return $this;
    }

    /**
     * {@see $duration}
     *
     * @param int $value
     *
     * @return FragmentCache
     */
    public function duration(int $value): FragmentCache
    {
        $this->duration = $value;

        return $this;
    }

    /**
     * @see $id
     *
     * @param string $value
     *
     * @return FragmentCache
     */
    public function id(string $value): FragmentCache
    {
        $this->id = $value;

        return $this;
    }

    /**
     * {@see $variations}
     *
     * @param string[]|string $value
     *
     * @return FragmentCache
     */
    public function variations($value): FragmentCache
    {
        $this->variations = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function getView(): WebView
    {
        return $this->webView;
    }
}
