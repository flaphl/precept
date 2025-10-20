<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Persister\Entity;

use Flaphl\Fridge\Precept\Cache\Persister\CachePersister;

/**
 * Entity-specific cache persister.
 * Handles caching of hydrated entity objects.
 */
class CacheEntityPersister extends CachePersister
{
    /**
     * Generate a cache key for an entity by its identifier.
     */
    public function generateKey(string $entityClass, mixed $id): string
    {
        $normalizedClass = str_replace('\\', '_', $entityClass);

        return sprintf('%s_%s', $normalizedClass, $this->normalizeId($id));
    }

    /**
     * Load an entity by its identifier.
     */
    public function loadById(string $entityClass, mixed $id): ?object
    {
        $key = $this->generateKey($entityClass, $id);

        return $this->load($key);
    }

    /**
     * Store an entity in cache by its identifier.
     */
    public function storeEntity(string $entityClass, mixed $id, object $entity, ?int $ttl = null): void
    {
        $key = $this->generateKey($entityClass, $id);

        $this->store($key, $entity, $ttl);
    }

    /**
     * Evict an entity from cache by its identifier.
     */
    public function evictEntity(string $entityClass, mixed $id): bool
    {
        $key = $this->generateKey($entityClass, $id);

        return $this->evict($key);
    }

    /**
     * Evict all entities of a specific class.
     */
    public function evictEntityClass(string $entityClass): void
    {
        // This would require tracking all keys per entity class
        // For now, evict all in the region
        $this->evictAll();
    }

    /**
     * Normalize an identifier to a string suitable for cache keys.
     */
    private function normalizeId(mixed $id): string
    {
        if (is_array($id)) {
            // Composite key
            ksort($id);
            return implode('_', array_map(fn($v) => (string) $v, $id));
        }

        if (is_object($id)) {
            if (method_exists($id, '__toString')) {
                return (string) $id;
            }

            return spl_object_hash($id);
        }

        return (string) $id;
    }
}
