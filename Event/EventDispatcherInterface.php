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

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

/**
 * Event dispatcher for ORM lifecycle events.
 */
interface EventDispatcherInterface extends PsrEventDispatcherInterface
{
    /**
     * Add an event listener.
     *
     * @param string $eventName The event name
     * @param callable $listener The listener callback
     * @param int $priority The priority (higher = earlier execution)
     *
     * @return void
     */
    public function addEventListener(string $eventName, callable $listener, int $priority = 0): void;

    /**
     * Remove an event listener.
     *
     * @param string $eventName The event name
     * @param callable $listener The listener to remove
     *
     * @return void
     */
    public function removeEventListener(string $eventName, callable $listener): void;

    /**
     * Check if event has listeners.
     *
     * @param string $eventName The event name
     *
     * @return bool True if has listeners
     */
    public function hasEventListeners(string $eventName): bool;

    /**
     * Get all listeners for an event.
     *
     * @param string $eventName The event name
     *
     * @return array<callable> The listeners
     */
    public function getEventListeners(string $eventName): array;
}
