<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Migrator;

/**
 * Repository for tracking migration execution history.
 */
interface MigrationRepositoryInterface
{
    /**
     * Get ran migrations.
     *
     * @return array<string> Migration names that have been executed
     */
    public function getRan(): array;

    /**
     * Get list of migrations organized by batch.
     *
     * @param int $steps Number of batches to retrieve
     *
     * @return array<array{migration: string, batch: int}> Migration records
     */
    public function getMigrations(int $steps): array;

    /**
     * Get the last batch of migrations.
     *
     * @return array<array{migration: string, batch: int}> Migration records
     */
    public function getLast(): array;

    /**
     * Get migrations for a specific batch number.
     *
     * @param int $batch The batch number
     *
     * @return array<array{migration: string, batch: int}> Migration records
     */
    public function getMigrationsByBatch(int $batch): array;

    /**
     * Log a migration as ran.
     *
     * @param string $migration The migration name
     * @param int $batch The batch number
     *
     * @return void
     */
    public function log(string $migration, int $batch): void;

    /**
     * Remove a migration from the log.
     *
     * @param string $migration The migration name
     *
     * @return void
     */
    public function delete(string $migration): void;

    /**
     * Get the next batch number.
     *
     * @return int The next batch number
     */
    public function getNextBatchNumber(): int;

    /**
     * Get the last batch number.
     *
     * @return int The last batch number
     */
    public function getLastBatchNumber(): int;

    /**
     * Create the migration repository data store.
     *
     * @return void
     */
    public function createRepository(): void;

    /**
     * Determine if the migration repository exists.
     *
     * @return bool True if repository exists
     */
    public function repositoryExists(): bool;

    /**
     * Delete the migration repository data store.
     *
     * @return void
     */
    public function deleteRepository(): void;
}
