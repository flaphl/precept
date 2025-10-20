<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Persister;

use Flaphl\Fridge\Precept\Cache\Region;
use Flaphl\Fridge\Precept\Cache\Logging\CacheLogger;

/**
 * Base cache persister for caching database entities and query results.
 */
abstract class CachePersister
{
    public function __construct(
        protected readonly Region $region,
        protected readonly ?CacheLogger $logger = null
    ) {
    }

    /**
     * Load an entity from cache.
     */
    public function load(string $key): mixed
    {
        if (!$this->region->contains($key)) {
            $this->logger?->logCacheMiss($this->region->getName(), $key);
            return null;
        }

        $value = $this->region->get($key);
        $this->logger?->logCacheHit($this->region->getName(), $key);

        return $value;
    }

    /**
     * Store an entity in cache.
     */
    public function store(string $key, mixed $value, ?int $ttl = null): void
    {
        $this->region->put($key, $value, $ttl);
        $this->logger?->logCachePut($this->region->getName(), $key, $value);
    }

    /**
     * Remove an entity from cache.
     */
    public function evict(string $key): bool
    {
        $result = $this->region->evict($key);

        if ($result) {
            $this->logger?->logCacheEviction($this->region->getName(), $key);
        }

        return $result;
    }

    /**
     * Clear all cached entities.
     */
    public function evictAll(): void
    {
        $this->region->evictAll();
        $this->logger?->logCacheClear($this->region->getName());
    }

    /**
     * Check if an entity exists in cache.
     */
    public function contains(string $key): bool
    {
        return $this->region->contains($key);
    }

    /**
     * Get cache statistics.
     */
    public function getStats(): array
    {
        return $this->region->getStats();
    }
}
