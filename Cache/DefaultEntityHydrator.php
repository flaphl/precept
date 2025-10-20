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

use Flaphl\Fridge\Precept\Hydration\HydrationInterface;

/**
 * Entity hydrator with caching support.
 * Caches hydrated entities to avoid repeated database queries.
 */
class DefaultEntityHydrator implements HydrationInterface
{
    public function __construct(
        private readonly HydrationInterface $hydrator,
        private readonly DefaultCache $cache,
        private readonly string $regionName = 'entities',
        private readonly ?int $ttl = null
    ) {
    }

    /**
     * Hydrate data into an entity with caching.
     */
    public function hydrate(array $data, string $class): object
    {
        $id = $this->extractId($data);

        if ($id !== null) {
            $key = $this->generateCacheKey($class, $id);
            $region = $this->cache->getRegion($this->regionName, $this->ttl);

            // Check cache first
            if ($region->contains($key)) {
                $cached = $region->get($key);
                if ($cached !== null) {
                    return $cached;
                }
            }
        }

        // Hydrate from data
        $entity = $this->hydrator->hydrate($data, $class);

        // Store in cache if we have an ID
        if (isset($id, $key, $region)) {
            $region->put($key, $entity, $this->ttl);
        }

        return $entity;
    }

    /**
     * Hydrate multiple entities with caching.
     *
     * @return object[]
     */
    public function hydrateAll(array $rows, string $class): array
    {
        $entities = [];
        $region = $this->cache->getRegion($this->regionName, $this->ttl);

        foreach ($rows as $data) {
            $id = $this->extractId($data);

            if ($id !== null) {
                $key = $this->generateCacheKey($class, $id);

                // Check cache
                if ($region->contains($key)) {
                    $cached = $region->get($key);
                    if ($cached !== null) {
                        $entities[] = $cached;
                        continue;
                    }
                }
            }

            // Hydrate and cache
            $entity = $this->hydrator->hydrate($data, $class);
            $entities[] = $entity;

            if (isset($id, $key)) {
                $region->put($key, $entity, $this->ttl);
            }
        }

        return $entities;
    }

    /**
     * Evict an entity from cache.
     */
    public function evict(string $class, mixed $id): void
    {
        $key = $this->generateCacheKey($class, $id);
        $region = $this->cache->getRegion($this->regionName);

        $region->evict($key);
    }

    /**
     * Extract the ID from data array.
     */
    private function extractId(array $data): mixed
    {
        return $data['id'] ?? null;
    }

    /**
     * Generate a cache key for an entity.
     */
    private function generateCacheKey(string $class, mixed $id): string
    {
        $normalizedClass = str_replace('\\', '_', $class);

        return sprintf('%s_%s', $normalizedClass, $id);
    }
}
