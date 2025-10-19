<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Repository;

/**
 * Factory interface for creating repository instances.
 */
interface RepositoryFactoryInterface
{
    /**
     * Create a repository for an entity class.
     *
     * @template T of \Flaphl\Fridge\Precept\Entity\EntityInterface
     * @param class-string<T> $entityClass The entity class name
     *
     * @return RepositoryInterface<T> The repository instance
     */
    public function createRepository(string $entityClass): RepositoryInterface;
}
