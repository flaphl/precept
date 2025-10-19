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

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;

/**
 * Executes database migrations.
 */
interface MigratorInterface
{
    /**
     * Run pending migrations.
     *
     * @param array<string, MigrationInterface> $migrations Available migrations
     * @param array $options Migration options (e.g., 'step', 'pretend')
     *
     * @return array<string> Names of migrations that were executed
     */
    public function run(array $migrations, array $options = []): array;

    /**
     * Rollback the last batch of migrations.
     *
     * @param array<string, MigrationInterface> $migrations Available migrations
     * @param array $options Rollback options (e.g., 'step', 'pretend')
     *
     * @return array<string> Names of migrations that were rolled back
     */
    public function rollback(array $migrations, array $options = []): array;

    /**
     * Reset all migrations.
     *
     * @param array<string, MigrationInterface> $migrations Available migrations
     * @param array $options Reset options
     *
     * @return array<string> Names of migrations that were reset
     */
    public function reset(array $migrations, array $options = []): array;

    /**
     * Get the next batch number.
     *
     * @return int The next batch number
     */
    public function getNextBatchNumber(): int;

    /**
     * Get the last batch of migrations.
     *
     * @return array<array{migration: string, batch: int}> Migration records
     */
    public function getLastBatch(): array;

    /**
     * Get pending migrations.
     *
     * @param array<string, MigrationInterface> $migrations Available migrations
     *
     * @return array<string, MigrationInterface> Migrations not yet run
     */
    public function getPendingMigrations(array $migrations): array;

    /**
     * Get ran migrations.
     *
     * @return array<string> Migration names that have been executed
     */
    public function getRanMigrations(): array;

    /**
     * Get the connection used by the migrator.
     *
     * @return ConnectionInterface The database connection
     */
    public function getConnection(): ConnectionInterface;

    /**
     * Set the connection for migrations.
     *
     * @param ConnectionInterface $connection The database connection
     *
     * @return self
     */
    public function setConnection(ConnectionInterface $connection): self;

    /**
     * Set the output handler for migration messages.
     *
     * @param callable(string): void $output Output callback
     *
     * @return self
     */
    public function setOutput(callable $output): self;
}
