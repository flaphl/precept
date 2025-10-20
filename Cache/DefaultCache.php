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

use Flaphl\Fridge\Precept\Cache\Region\DefaultRegion;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Default cache implementation for Precept.
 * Provides basic caching functionality with region support.
 */
class DefaultCache
{
    /** @var array<string, Region> */
    private array $regions = [];

    public function __construct(
        private readonly CacheItemPoolInterface $cachePool,
        private readonly ?int $defaultTtl = 3600
    ) {
    }

    /**
     * Get or create a cache region.
     */
    public function getRegion(string $name, ?int $ttl = null): Region
    {
        if (!isset($this->regions[$name])) {
            $effectiveTtl = $ttl ?? $this->defaultTtl;
            $this->regions[$name] = new DefaultRegion($name, $this->cachePool, $effectiveTtl);
        }

        return $this->regions[$name];
    }

    /**
     * Check if a region exists.
     */
    public function hasRegion(string $name): bool
    {
        return isset($this->regions[$name]);
    }

    /**
     * Remove a region and all its entries.
     */
    public function evictRegion(string $name): void
    {
        if (isset($this->regions[$name])) {
            $this->regions[$name]->evictAll();
            unset($this->regions[$name]);
        }
    }

    /**
     * Clear all regions.
     */
    public function clear(): void
    {
        foreach ($this->regions as $region) {
            $region->evictAll();
        }

        $this->regions = [];
        $this->cachePool->clear();
    }

    /**
     * Get statistics for all regions.
     *
     * @return array<string, array{hits: int, misses: int, puts: int, evictions: int}>
     */
    public function getStats(): array
    {
        $stats = [];

        foreach ($this->regions as $name => $region) {
            $stats[$name] = $region->getStats();
        }

        return $stats;
    }

    /**
     * Get the underlying cache pool.
     */
    public function getCachePool(): CacheItemPoolInterface
    {
        return $this->cachePool;
    }
}
