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

use Flaphl\Fridge\Precept\Cache\Lock;
use Flaphl\Fridge\Precept\Cache\Region;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Cache region with file-based locking for concurrent access protection.
 */
class FileLockRegion extends DefaultRegion
{
    private readonly Lock $lock;

    public function __construct(
        string $name,
        CacheItemPoolInterface $cache,
        ?int $defaultTtl = null,
        ?Lock $lock = null
    ) {
        parent::__construct($name, $cache, $defaultTtl);
        $this->lock = $lock ?? new Lock($cache);
    }

    public function get(string $key): mixed
    {
        return $this->lock->executeWithLock(
            $this->getLockKey($key),
            fn() => parent::get($key),
            timeout: 1.0
        );
    }

    public function put(string $key, mixed $value, ?int $ttl = null): void
    {
        $this->lock->executeWithLock(
            $this->getLockKey($key),
            fn() => parent::put($key, $value, $ttl),
            timeout: 1.0
        );
    }

    public function evict(string $key): bool
    {
        return $this->lock->executeWithLock(
            $this->getLockKey($key),
            fn() => parent::evict($key),
            timeout: 1.0
        );
    }

    private function getLockKey(string $key): string
    {
        return sprintf('region_%s_%s', $this->getName(), $key);
    }
}
