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

use Flaphl\Fridge\Precept\Exception\PreceptException;

/**
 * Exception thrown when a cache operation fails.
 */
class CacheException extends PreceptException
{
    public static function forFailedCacheOperation(string $operation, string $reason): self
    {
        return new self(sprintf('Cache operation "%s" failed: %s', $operation, $reason));
    }

    public static function forInvalidCacheKey(string $key): self
    {
        return new self(sprintf('Invalid cache key: "%s"', $key));
    }

    public static function forMissingCacheConfiguration(string $entityClass): self
    {
        return new self(sprintf('No cache configuration found for entity "%s"', $entityClass));
    }

    public static function forExpiredCache(string $key): self
    {
        return new self(sprintf('Cache entry expired for key: "%s"', $key));
    }
}
