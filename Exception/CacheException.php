<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Exception;

/**
 * Exception thrown when there's a cache error.
 */
class CacheException extends PreceptException implements \Psr\Cache\CacheException
{
    /**
     * Create exception for cache invalidation failure.
     *
     * @param string $reason The reason for failure
     *
     * @return static
     */
    public static function invalidationFailed(string $reason): static
    {
        return new static(
            sprintf('Cache invalidation failed: %s', $reason)
        );
    }

    /**
     * Create exception for cache warming failure.
     *
     * @param string $entityClass The entity class being warmed
     * @param \Throwable $previous The previous exception
     *
     * @return static
     */
    public static function warmingFailed(string $entityClass, \Throwable $previous): static
    {
        return new static(
            sprintf('Failed to warm cache for entity "%s".', $entityClass),
            0,
            $previous
        );
    }
}
