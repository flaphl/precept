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
 * Event dispatched before updating an entity.
 */
interface PreUpdateEventInterface extends LifecycleEventInterface
{
    /**
     * Get the entity change set.
     *
     * @return array<string, array{0: mixed, 1: mixed}> Field => [old, new]
     */
    public function getChangeSet(): array;

    /**
     * Check if a field has changed.
     *
     * @param string $field The field name
     *
     * @return bool True if changed
     */
    public function hasChangedField(string $field): bool;

    /**
     * Get old value of a field.
     *
     * @param string $field The field name
     *
     * @return mixed The old value
     */
    public function getOldValue(string $field): mixed;

    /**
     * Get new value of a field.
     *
     * @param string $field The field name
     *
     * @return mixed The new value
     */
    public function getNewValue(string $field): mixed;

    /**
     * Set a new value for a field.
     *
     * @param string $field The field name
     * @param mixed $value The new value
     *
     * @return void
     */
    public function setNewValue(string $field, mixed $value): void;
}
