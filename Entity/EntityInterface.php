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
 * Base interface for all ORM entities.
 *
 * Entities represent persistent domain objects that are managed by the EntityManager.
 * They have identity, lifecycle, and can be persisted to and loaded from storage.
 */
interface EntityInterface
{
    /**
     * Get the unique identifier for this entity.
     *
     * Returns null if the entity has not been persisted yet.
     *
     * @return mixed The entity identifier, or null if not persisted
     */
    public function getId(): mixed;

    /**
     * Check if this entity has been persisted.
     *
     * @return bool True if the entity has been persisted and has an ID
     */
    public function isPersisted(): bool;

    /**
     * Get the entity class name.
     *
     * Useful for polymorphic relationships and entity type detection.
     *
     * @return string The fully qualified class name
     */
    public function getEntityName(): string;
}
