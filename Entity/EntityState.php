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
 * Entity state enumeration.
 *
 * Represents the lifecycle state of an entity in the Unit of Work.
 */
enum EntityState: string
{
    /**
     * Entity is new and not yet persisted.
     */
    case NEW = 'new';

    /**
     * Entity is managed and tracked for changes.
     */
    case MANAGED = 'managed';

    /**
     * Entity is scheduled for removal.
     */
    case REMOVED = 'removed';

    /**
     * Entity is detached and no longer tracked.
     */
    case DETACHED = 'detached';

    /**
     * Check if the entity is tracked for changes.
     */
    public function isTracked(): bool
    {
        return $this === self::MANAGED;
    }

    /**
     * Check if the entity will be persisted on flush.
     */
    public function willPersist(): bool
    {
        return $this === self::NEW || $this === self::MANAGED;
    }

    /**
     * Check if the entity will be removed on flush.
     */
    public function willRemove(): bool
    {
        return $this === self::REMOVED;
    }
}
