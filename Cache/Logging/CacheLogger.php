<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Logging;

/**
 * Logger for cache operations.
 */
interface CacheLogger
{
    /**
     * Log a cache hit.
     */
    public function logCacheHit(string $region, string $key): void;

    /**
     * Log a cache miss.
     */
    public function logCacheMiss(string $region, string $key): void;

    /**
     * Log a cache put operation.
     */
    public function logCachePut(string $region, string $key, mixed $value): void;

    /**
     * Log a cache eviction.
     */
    public function logCacheEviction(string $region, string $key): void;

    /**
     * Log a cache clear operation.
     */
    public function logCacheClear(string $region): void;
}
