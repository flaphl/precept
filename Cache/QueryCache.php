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

/**
 * Query result cache for caching database query results.
 */
class QueryCache
{
    private const REGION_NAME = 'query_results';

    public function __construct(
        private readonly DefaultCache $cache,
        private readonly ?int $defaultTtl = 3600
    ) {
    }

    /**
     * Get cached query result.
     */
    public function get(string $sql, array $params = []): mixed
    {
        $key = $this->generateKey($sql, $params);
        $region = $this->cache->getRegion(self::REGION_NAME, $this->defaultTtl);

        return $region->get($key);
    }

    /**
     * Store query result in cache.
     */
    public function put(string $sql, array $params, mixed $result, ?int $ttl = null): void
    {
        $key = $this->generateKey($sql, $params);
        $region = $this->cache->getRegion(self::REGION_NAME, $this->defaultTtl);

        $region->put($key, $result, $ttl);
    }

    /**
     * Check if query result is cached.
     */
    public function contains(string $sql, array $params = []): bool
    {
        $key = $this->generateKey($sql, $params);
        $region = $this->cache->getRegion(self::REGION_NAME);

        return $region->contains($key);
    }

    /**
     * Evict a specific query result.
     */
    public function evict(string $sql, array $params = []): bool
    {
        $key = $this->generateKey($sql, $params);
        $region = $this->cache->getRegion(self::REGION_NAME);

        return $region->evict($key);
    }

    /**
     * Clear all cached query results.
     */
    public function evictAll(): void
    {
        $this->cache->evictRegion(self::REGION_NAME);
    }

    /**
     * Execute a query with caching.
     *
     * @template T
     * @param callable(): T $callback
     * @return T
     */
    public function executeWithCache(string $sql, array $params, callable $callback, ?int $ttl = null): mixed
    {
        $key = $this->generateKey($sql, $params);
        $region = $this->cache->getRegion(self::REGION_NAME, $this->defaultTtl);

        if ($region->contains($key)) {
            $cached = $region->get($key);
            if ($cached !== null) {
                return $cached;
            }
        }

        $result = $callback();

        $region->put($key, $result, $ttl);

        return $result;
    }

    /**
     * Generate a cache key from SQL and parameters.
     */
    private function generateKey(string $sql, array $params): string
    {
        $normalized = preg_replace('/\s+/', ' ', trim($sql));
        $paramString = serialize($params);

        return md5($normalized . $paramString);
    }

    /**
     * Get cache statistics.
     */
    public function getStats(): array
    {
        $region = $this->cache->getRegion(self::REGION_NAME);

        return $region->getStats();
    }
}
