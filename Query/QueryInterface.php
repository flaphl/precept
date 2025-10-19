<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Query;

use Flaphl\Fridge\Precept\Entity\EntityInterface;

/**
 * Query interface for executing queries.
 */
interface QueryInterface
{
    /**
     * Execute the query and return results.
     *
     * @return array<EntityInterface> The query results
     */
    public function getResult(): array;

    /**
     * Execute and get a single result.
     *
     * @return EntityInterface|null The single result or null
     */
    public function getSingleResult(): ?EntityInterface;

    /**
     * Execute and get a single scalar result.
     *
     * @return mixed The scalar result
     */
    public function getSingleScalarResult(): mixed;

    /**
     * Execute and get an array result.
     *
     * @return array<array<string, mixed>> Array of arrays
     */
    public function getArrayResult(): array;

    /**
     * Set the hydration mode.
     *
     * @param HydrationMode $mode The hydration mode
     *
     * @return self
     */
    public function setHydrationMode(HydrationMode $mode): self;

    /**
     * Set a query parameter.
     *
     * @param string|int $key The parameter key
     * @param mixed $value The parameter value
     *
     * @return self
     */
    public function setParameter(string|int $key, mixed $value): self;

    /**
     * Set multiple parameters.
     *
     * @param array<string|int, mixed> $parameters The parameters
     *
     * @return self
     */
    public function setParameters(array $parameters): self;

    /**
     * Execute the query.
     *
     * @return mixed The result
     */
    public function execute(): mixed;
}
