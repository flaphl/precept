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

/**
 * Cache warmer interface for preloading cache data.
 */
interface CacheWarmerInterface
{
    /**
     * Warm up caches for specific entities.
     *
     * @param array<string> $entityClasses Entity class names
     * @param array<string, mixed> $options Warming options
     *
     * @return array<string, int> Statistics (entities, queries, etc.)
     */
    public function warmUp(array $entityClasses, array $options = []): array;

    /**
     * Check if cache warmer is enabled.
     *
     * @return bool True if enabled
     */
    public function isEnabled(): bool;

    /**
     * Get warming statistics.
     *
     * @return array<string, mixed> Statistics
     */
    public function getStatistics(): array;
}
