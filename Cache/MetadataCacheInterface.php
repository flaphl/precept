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

use Flaphl\Contracts\Cache\CacheInterface;

/**
 * Metadata cache interface for entity metadata.
 */
interface MetadataCacheInterface extends CacheInterface
{
    /**
     * Cache entity metadata.
     *
     * @param string $entityClass The entity class name
     * @param array<string, mixed> $metadata The metadata
     * @param int|null $lifetime Cache lifetime in seconds
     *
     * @return bool True on success
     */
    public function cacheMetadata(string $entityClass, array $metadata, ?int $lifetime = null): bool;

    /**
     * Get cached metadata for an entity.
     *
     * @param string $entityClass The entity class name
     *
     * @return array<string, mixed>|null The metadata or null
     */
    public function getMetadata(string $entityClass): ?array;

    /**
     * Check if metadata is cached.
     *
     * @param string $entityClass The entity class name
     *
     * @return bool True if cached
     */
    public function hasMetadata(string $entityClass): bool;

    /**
     * Invalidate metadata for an entity.
     *
     * @param string $entityClass The entity class name
     *
     * @return bool True on success
     */
    public function invalidateMetadata(string $entityClass): bool;

    /**
     * Invalidate all cached metadata.
     *
     * @return bool True on success
     */
    public function invalidateAll(): bool;

    /**
     * Warm up the cache with entity metadata.
     *
     * @param array<string> $entityClasses Entity class names
     *
     * @return int Number of entities cached
     */
    public function warmUp(array $entityClasses): int;
}
