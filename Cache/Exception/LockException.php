<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Cache\Exception;

/**
 * Exception thrown when a cache lock operation fails.
 */
class LockException extends CacheException
{
    public static function forFailedToAcquireLock(string $key, float $timeout): self
    {
        return new self(sprintf('Failed to acquire lock for key "%s" within %0.2f seconds', $key, $timeout));
    }

    public static function forFailedToReleaseLock(string $key, string $reason): self
    {
        return new self(sprintf('Failed to release lock for key "%s": %s', $key, $reason));
    }

    public static function forLockAlreadyAcquired(string $key): self
    {
        return new self(sprintf('Lock already acquired for key: "%s"', $key));
    }

    public static function forInvalidLockToken(string $key, string $token): self
    {
        return new self(sprintf('Invalid lock token "%s" for key: "%s"', $token, $key));
    }
}
