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
 * Resolves migration files to executable migration instances.
 */
interface MigrationResolverInterface
{
    /**
     * Resolve all migration files in a directory.
     *
     * @param array<string> $paths Directories containing migration files
     *
     * @return array<string, MigrationInterface> Migrations keyed by name
     */
    public function getMigrations(array $paths): array;

    /**
     * Resolve a single migration file.
     *
     * @param string $file Path to migration file
     *
     * @return MigrationInterface The migration instance
     */
    public function resolveMigration(string $file): MigrationInterface;

    /**
     * Get migration name from file path.
     *
     * @param string $file Path to migration file
     *
     * @return string The migration name
     */
    public function getMigrationName(string $file): string;

    /**
     * Get migration class name from file.
     *
     * @param string $file Path to migration file
     *
     * @return string The fully qualified class name
     */
    public function getMigrationClass(string $file): string;

    /**
     * Check if a file is a valid migration.
     *
     * @param string $file Path to check
     *
     * @return bool True if file is a migration
     */
    public function isMigrationFile(string $file): bool;

    /**
     * Sort migrations by their names (timestamp-based).
     *
     * @param array<string, MigrationInterface> $migrations Migrations to sort
     *
     * @return array<string, MigrationInterface> Sorted migrations
     */
    public function sortMigrations(array $migrations): array;
}
