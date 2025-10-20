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
 * Cache region interface for storing related cache entries.
 * Regions allow for grouped invalidation and TTL management.
 */
interface Region
{
    /**
     * Get the region name.
     */
    public function getName(): string;

    /**
     * Check if an entry exists in the region.
     */
    public function contains(string $key): bool;

    /**
     * Get an entry from the region.
     */
    public function get(string $key): mixed;

    /**
     * Put an entry into the region.
     */
    public function put(string $key, mixed $value, ?int $ttl = null): void;

    /**
     * Remove an entry from the region.
     */
    public function evict(string $key): bool;

    /**
     * Clear all entries from the region.
     */
    public function evictAll(): void;

    /**
     * Get the default TTL for this region.
     */
    public function getDefaultTtl(): ?int;

    /**
     * Get statistics for this region.
     *
     * @return array{hits: int, misses: int, puts: int, evictions: int}
     */
    public function getStats(): array;
}
