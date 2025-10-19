<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Entity;

use Flaphl\Fridge\Precept\Repository\RepositoryInterface;

/**
 * Central interface for managing entity persistence and lifecycle.
 *
 * The EntityManager is the primary entry point for ORM operations, responsible for:
 * - Persisting and removing entities
 * - Managing entity lifecycle and state
 * - Coordinating with the Unit of Work
 * - Providing repository access
 * - Managing transactions
 */
interface EntityManagerInterface
{
    /**
     * Find an entity by its identifier.
     *
     * @param class-string<EntityInterface> $entityClass The entity class name
     * @param mixed $id The entity identifier
     *
     * @return EntityInterface|null The entity if found, null otherwise
     */
    public function find(string $entityClass, mixed $id): ?EntityInterface;

    /**
     * Persist an entity to be saved on flush.
     *
     * The entity will be inserted or updated depending on its state.
     *
     * @param EntityInterface $entity The entity to persist
     *
     * @return void
     */
    public function persist(EntityInterface $entity): void;

    /**
     * Remove an entity to be deleted on flush.
     *
     * @param EntityInterface $entity The entity to remove
     *
     * @return void
     */
    public function remove(EntityInterface $entity): void;

    /**
     * Flush all pending changes to the database.
     *
     * Executes all pending inserts, updates, and deletes.
     *
     * @return void
     */
    public function flush(): void;

    /**
     * Refresh an entity from the database.
     *
     * Discards any unflushed changes and reloads from storage.
     *
     * @param EntityInterface $entity The entity to refresh
     *
     * @return void
     */
    public function refresh(EntityInterface $entity): void;

    /**
     * Detach an entity from management.
     *
     * The entity will no longer be tracked for changes.
     *
     * @param EntityInterface $entity The entity to detach
     *
     * @return void
     */
    public function detach(EntityInterface $entity): void;

    /**
     * Clear all managed entities.
     *
     * Detaches all entities, discarding any unflushed changes.
     *
     * @param string|null $entityClass Optionally clear only a specific entity type
     *
     * @return void
     */
    public function clear(?string $entityClass = null): void;

    /**
     * Check if an entity is managed.
     *
     * @param EntityInterface $entity The entity to check
     *
     * @return bool True if the entity is managed
     */
    public function contains(EntityInterface $entity): bool;

    /**
     * Get a repository for an entity class.
     *
     * @template T of EntityInterface
     * @param class-string<T> $entityClass The entity class name
     *
     * @return RepositoryInterface<T> The repository instance
     */
    public function getRepository(string $entityClass): RepositoryInterface;

    /**
     * Execute a function within a transaction.
     *
     * If the function executes successfully, the transaction is committed.
     * If an exception occurs, the transaction is rolled back.
     *
     * @param callable $callback The function to execute
     *
     * @return mixed The return value of the callback
     */
    public function transactional(callable $callback): mixed;

    /**
     * Begin a transaction.
     *
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * Commit the current transaction.
     *
     * @return void
     */
    public function commit(): void;

    /**
     * Rollback the current transaction.
     *
     * @return void
     */
    public function rollback(): void;

    /**
     * Get the Unit of Work.
     *
     * @return UnitOfWorkInterface The Unit of Work instance
     */
    public function getUnitOfWork(): UnitOfWorkInterface;
}
