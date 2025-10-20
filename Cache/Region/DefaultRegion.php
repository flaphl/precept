<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Region;

use Flaphl\Fridge\Precept\Cache\Region;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Default cache region implementation using PSR-6 cache.
 */
class DefaultRegion implements Region
{
    private array $stats = [
        'hits' => 0,
        'misses' => 0,
        'puts' => 0,
        'evictions' => 0,
    ];

    public function __construct(
        private readonly string $name,
        private readonly CacheItemPoolInterface $cache,
        private readonly ?int $defaultTtl = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function contains(string $key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $item = $this->cache->getItem($cacheKey);

        return $item->isHit();
    }

    public function get(string $key): mixed
    {
        $cacheKey = $this->getCacheKey($key);
        $item = $this->cache->getItem($cacheKey);

        if ($item->isHit()) {
            $this->stats['hits']++;
            return $item->get();
        }

        $this->stats['misses']++;
        return null;
    }

    public function put(string $key, mixed $value, ?int $ttl = null): void
    {
        $cacheKey = $this->getCacheKey($key);
        $item = $this->cache->getItem($cacheKey);

        $item->set($value);

        $effectiveTtl = $ttl ?? $this->defaultTtl;
        if ($effectiveTtl !== null) {
            $item->expiresAfter($effectiveTtl);
        }

        $this->cache->save($item);
        $this->stats['puts']++;
    }

    public function evict(string $key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $result = $this->cache->deleteItem($cacheKey);

        if ($result) {
            $this->stats['evictions']++;
        }

        return $result;
    }

    public function evictAll(): void
    {
        // Clear items with region prefix
        $this->cache->clear();
        $this->stats['evictions']++;
    }

    public function getDefaultTtl(): ?int
    {
        return $this->defaultTtl;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    protected function getCacheKey(string $key): string
    {
        return sprintf('%s_%s', $this->name, $key);
    }
}
