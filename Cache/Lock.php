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

use Flaphl\Fridge\Precept\Cache\Exception\LockException;

/**
 * Distributed cache lock implementation using PSR-6 cache.
 * Prevents concurrent modification of cached entities.
 */
class Lock
{
    private const DEFAULT_TTL = 30;
    private const LOCK_PREFIX = '_precept_lock_';

    public function __construct(
        private readonly \Psr\Cache\CacheItemPoolInterface $cache,
        private readonly int $ttl = self::DEFAULT_TTL
    ) {
    }

    /**
     * Attempt to acquire a lock for the given key.
     *
     * @throws LockException If lock cannot be acquired
     */
    public function acquire(string $key, float $timeout = 5.0): string
    {
        $lockKey = $this->getLockKey($key);
        $token = $this->generateToken();
        $start = microtime(true);

        while (true) {
            $item = $this->cache->getItem($lockKey);

            if (!$item->isHit()) {
                // Lock is available
                $item->set($token);
                $item->expiresAfter($this->ttl);
                $this->cache->save($item);

                return $token;
            }

            // Check timeout
            if ((microtime(true) - $start) >= $timeout) {
                throw LockException::forFailedToAcquireLock($key, $timeout);
            }

            // Wait before retry
            usleep(50000); // 50ms
        }
    }

    /**
     * Release a previously acquired lock.
     *
     * @throws LockException If lock cannot be released
     */
    public function release(string $key, string $token): void
    {
        $lockKey = $this->getLockKey($key);
        $item = $this->cache->getItem($lockKey);

        if (!$item->isHit()) {
            // Lock already released or expired
            return;
        }

        $currentToken = $item->get();

        if ($currentToken !== $token) {
            throw LockException::forInvalidLockToken($key, $token);
        }

        if (!$this->cache->deleteItem($lockKey)) {
            throw LockException::forFailedToReleaseLock($key, 'Cache delete failed');
        }
    }

    /**
     * Check if a lock exists for the given key.
     */
    public function isLocked(string $key): bool
    {
        $lockKey = $this->getLockKey($key);
        $item = $this->cache->getItem($lockKey);

        return $item->isHit();
    }

    /**
     * Execute a callback with an exclusive lock.
     *
     * @template T
     * @param callable(): T $callback
     * @return T
     * @throws LockException
     */
    public function executeWithLock(string $key, callable $callback, float $timeout = 5.0): mixed
    {
        $token = $this->acquire($key, $timeout);

        try {
            return $callback();
        } finally {
            $this->release($key, $token);
        }
    }

    private function getLockKey(string $key): string
    {
        return self::LOCK_PREFIX . $key;
    }

    private function generateToken(): string
    {
        return bin2hex(random_bytes(16));
    }
}
