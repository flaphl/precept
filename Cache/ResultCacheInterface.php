<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache;

use Flaphl\Contracts\Cache\TagAwareCacheInterface;

/**
 * Result cache interface for ORM query results.
 * 
 * Extends Flaphl's TagAwareCacheInterface to provide ORM-specific
 * caching functionality with tag-based invalidation support.
 */
interface ResultCacheInterface extends TagAwareCacheInterface
{
    /**
     * Cache a query result with optional tags.
     *
     * @param string $key The cache key
     * @param mixed $result The result to cache
     * @param int|null $lifetime Cache lifetime in seconds
     * @param array<string>|null $tags Optional cache tags
     *
     * @return bool True on success
     */
    public function cacheResult(string $key, mixed $result, ?int $lifetime = null, ?array $tags = null): bool;

    /**
     * Get a cached result.
     *
     * @param string $key The cache key
     *
     * @return mixed|null The cached result or null
     */
    public function getCachedResult(string $key): mixed;

    /**
     * Check if result is cached.
     *
     * @param string $key The cache key
     *
     * @return bool True if cached
     */
    public function hasCachedResult(string $key): bool;

    /**
     * Cache a query result with computed callback.
     *
     * @param string $key The cache key
     * @param callable $callback Callback to compute value if not cached
     * @param int|null $lifetime Cache lifetime in seconds
     * @param array<string>|null $tags Optional cache tags
     *
     * @return mixed The cached or computed value
     */
    public function cacheQuery(string $key, callable $callback, ?int $lifetime = null, ?array $tags = null): mixed;

    /**
     * Invalidate cache by entity class.
     *
     * @param string $entityClass The entity class name
     *
     * @return bool True on success
     */
    public function invalidateEntityCache(string $entityClass): bool;
}
