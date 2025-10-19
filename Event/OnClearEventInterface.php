<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Event;

/**
 * Event triggered when entity manager is cleared.
 * 
 * Fired when EntityManager::clear() is called, removing all entities
 * from memory or a specific entity class if provided.
 */
interface OnClearEventInterface extends LifecycleEventInterface
{
    /**
     * Get the entity class being cleared, or null for all entities.
     *
     * @return string|null The entity class or null for clearing all
     */
    public function getEntityClass(): ?string;

    /**
     * Check if all entities are being cleared.
     *
     * @return bool True if clearing all entities
     */
    public function clearsAllEntities(): bool;
}
