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

/**
 * Unit of Work pattern implementation interface.
 *
 * Manages entity state, tracks changes, and coordinates persistence operations.
 * The Unit of Work maintains consistency by grouping operations into transactions.
 */
interface UnitOfWorkInterface
{
    /**
     * Register an entity as new (to be inserted).
     *
     * @param EntityInterface $entity The entity to register
     *
     * @return void
     */
    public function registerNew(EntityInterface $entity): void;

    /**
     * Register an entity as managed (tracked for changes).
     *
     * @param EntityInterface $entity The entity to register
     *
     * @return void
     */
    public function registerManaged(EntityInterface $entity): void;

    /**
     * Register an entity for removal (to be deleted).
     *
     * @param EntityInterface $entity The entity to register
     *
     * @return void
     */
    public function registerRemoved(EntityInterface $entity): void;

    /**
     * Register an entity as detached (no longer tracked).
     *
     * @param EntityInterface $entity The entity to register
     *
     * @return void
     */
    public function registerDetached(EntityInterface $entity): void;

    /**
     * Get the state of an entity.
     *
     * @param EntityInterface $entity The entity to check
     *
     * @return EntityState The entity's current state
     */
    public function getEntityState(EntityInterface $entity): EntityState;

    /**
     * Check if an entity is managed.
     *
     * @param EntityInterface $entity The entity to check
     *
     * @return bool True if the entity is managed
     */
    public function isManaged(EntityInterface $entity): bool;

    /**
     * Check if an entity has changes.
     *
     * @param EntityInterface $entity The entity to check
     *
     * @return bool True if the entity has pending changes
     */
    public function hasChanges(EntityInterface $entity): bool;

    /**
     * Get the original data for a managed entity.
     *
     * @param EntityInterface $entity The entity
     *
     * @return array<string, mixed> The original field values
     */
    public function getOriginalData(EntityInterface $entity): array;

    /**
     * Get the changeset for a managed entity.
     *
     * Returns an array where keys are field names and values are [old, new] pairs.
     *
     * @param EntityInterface $entity The entity
     *
     * @return array<string, array{0: mixed, 1: mixed}> The changeset
     */
    public function getEntityChangeSet(EntityInterface $entity): array;

    /**
     * Compute changes for all managed entities.
     *
     * Detects which entities have been modified and prepares changesets.
     *
     * @return void
     */
    public function computeChangeSets(): void;

    /**
     * Commit all pending changes.
     *
     * Executes inserts, updates, and deletes in the correct order.
     *
     * @return void
     */
    public function commit(): void;

    /**
     * Clear all tracked entities.
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Get all managed entities.
     *
     * @return array<EntityInterface> All currently managed entities
     */
    public function getManagedEntities(): array;

    /**
     * Get all entities scheduled for insertion.
     *
     * @return array<EntityInterface> Entities to be inserted
     */
    public function getScheduledInsertions(): array;

    /**
     * Get all entities scheduled for update.
     *
     * @return array<EntityInterface> Entities to be updated
     */
    public function getScheduledUpdates(): array;

    /**
     * Get all entities scheduled for deletion.
     *
     * @return array<EntityInterface> Entities to be deleted
     */
    public function getScheduledDeletions(): array;
}
