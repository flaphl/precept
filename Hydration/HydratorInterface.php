<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Hydration;

use Flaphl\Fridge\Precept\Query\HydrationMode;

/**
 * Hydrator interface for converting database results to entities.
 */
interface HydratorInterface
{
    /**
     * Hydrate a result set.
     *
     * @param array<array<string, mixed>> $rows The result rows
     * @param HydrationMode $mode The hydration mode
     *
     * @return array<mixed> The hydrated results
     */
    public function hydrateAll(array $rows, HydrationMode $mode): array;

    /**
     * Hydrate a single row to an entity.
     *
     * @param array<string, mixed> $row The row data
     * @param string $entityClass The entity class name
     *
     * @return object The entity instance
     */
    public function hydrateEntity(array $row, string $entityClass): object;

    /**
     * Hydrate a row to an array.
     *
     * @param array<string, mixed> $row The row data
     *
     * @return array<string, mixed> The hydrated array
     */
    public function hydrateArray(array $row): array;

    /**
     * Hydrate a single scalar value.
     *
     * @param array<string, mixed> $row The row data
     *
     * @return mixed The scalar value
     */
    public function hydrateScalar(array $row): mixed;
}
