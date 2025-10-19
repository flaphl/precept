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
 * Exception thrown when there's a hydration error.
 */
class HydrationException extends PreceptException
{
    /**
     * Create exception for hydration failure.
     *
     * @param string $entityClass The entity class being hydrated
     * @param string $reason The reason for failure
     *
     * @return static
     */
    public static function hydratingEntity(string $entityClass, string $reason): static
    {
        return new static(
            sprintf('Failed to hydrate entity "%s": %s', $entityClass, $reason)
        );
    }

    /**
     * Create exception for unknown hydration mode.
     *
     * @param string $mode The unknown hydration mode
     *
     * @return static
     */
    public static function unknownMode(string $mode): static
    {
        return new static(
            sprintf('Unknown hydration mode: %s', $mode)
        );
    }
}
