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

use Flaphl\Fridge\Precept\Entity\EntityInterface;
use Flaphl\Fridge\Precept\Query\QueryBuilderInterface;

/**
 * Base repository interface for entity persistence operations.
 *
 * @template T of EntityInterface
 */
interface RepositoryInterface
{
    /**
     * Find an entity by its identifier.
     *
     * @param mixed $id The entity identifier
     *
     * @return T|null The entity if found, null otherwise
     */
    public function find(mixed $id): ?EntityInterface;

    /**
     * Find all entities.
     *
     * @return array<T> All entities of this type
     */
    public function findAll(): array;

    /**
     * Find entities matching criteria.
     *
     * @param array<string, mixed> $criteria Field-value pairs to match
     * @param array<string, string>|null $orderBy Field-direction pairs for sorting
     * @param int|null $limit Maximum number of results
     * @param int|null $offset Result offset
     *
     * @return array<T> Matching entities
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array;

    /**
     * Find a single entity matching criteria.
     *
     * @param array<string, mixed> $criteria Field-value pairs to match
     *
     * @return T|null The entity if found, null otherwise
     */
    public function findOneBy(array $criteria): ?EntityInterface;

    /**
     * Count entities matching criteria.
     *
     * @param array<string, mixed> $criteria Field-value pairs to match
     *
     * @return int The count of matching entities
     */
    public function count(array $criteria = []): int;

    /**
     * Create a query builder for this repository.
     *
     * @param string|null $alias The entity alias to use
     *
     * @return QueryBuilderInterface The query builder instance
     */
    public function createQueryBuilder(?string $alias = null): QueryBuilderInterface;

    /**
     * Get the entity class name managed by this repository.
     *
     * @return class-string<T> The entity class name
     */
    public function getClassName(): string;
}
