<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\DataCollector;

use Flaphl\Fridge\Precept\Entity\EntityManagerInterface;

/**
 * Data collector for debugging and profiling ORM operations.
 * 
 * Collects information about queries, entities, hydrations, and performance
 * metrics during request lifecycle for debugging and optimization purposes.
 */
interface DataCollectorInterface
{
    /**
     * Set the entity manager to collect data from.
     *
     * @param EntityManagerInterface $entityManager The entity manager
     *
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void;

    /**
     * Collect data about executed queries.
     *
     * @return array{
     *     count: int,
     *     queries: array<array{sql: string, params: array, time: float, trace: array}>,
     *     totalTime: float
     * }
     */
    public function getQueries(): array;

    /**
     * Collect data about managed entities.
     *
     * @return array{
     *     count: int,
     *     entities: array<array{class: string, id: mixed, state: string}>
     * }
     */
    public function getEntities(): array;

    /**
     * Collect data about hydrations performed.
     *
     * @return array{
     *     count: int,
     *     hydrations: array<array{class: string, mode: string, count: int, time: float}>
     * }
     */
    public function getHydrations(): array;

    /**
     * Get cache statistics.
     *
     * @return array{
     *     hits: int,
     *     misses: int,
     *     puts: int,
     *     hitRate: float
     * }
     */
    public function getCacheStats(): array;

    /**
     * Get connection information.
     *
     * @return array{
     *     driver: string,
     *     host: string,
     *     database: string,
     *     connected: bool
     * }
     */
    public function getConnectionInfo(): array;

    /**
     * Get metadata about registered entities.
     *
     * @return array<array{
     *     class: string,
     *     table: string,
     *     fields: int,
     *     associations: int
     * }>
     */
    public function getMetadata(): array;

    /**
     * Get Unit of Work statistics.
     *
     * @return array{
     *     scheduledInserts: int,
     *     scheduledUpdates: int,
     *     scheduledDeletions: int,
     *     totalScheduled: int
     * }
     */
    public function getUnitOfWorkStats(): array;

    /**
     * Get performance metrics.
     *
     * @return array{
     *     totalQueryTime: float,
     *     totalHydrationTime: float,
     *     peakMemory: int,
     *     currentMemory: int
     * }
     */
    public function getPerformanceMetrics(): array;

    /**
     * Start collecting data.
     *
     * @return void
     */
    public function startCollection(): void;

    /**
     * Stop collecting data.
     *
     * @return void
     */
    public function stopCollection(): void;

    /**
     * Check if currently collecting.
     *
     * @return bool True if collecting
     */
    public function isCollecting(): bool;

    /**
     * Reset all collected data.
     *
     * @return void
     */
    public function reset(): void;

    /**
     * Get all collected data.
     *
     * @return array<string, mixed> All collected data
     */
    public function getData(): array;

    /**
     * Get data collector name.
     *
     * @return string The collector name
     */
    public function getName(): string;
}
