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
 * Creates migration files from templates.
 */
interface MigrationCreatorInterface
{
    /**
     * Create a new migration file.
     *
     * @param string $name Migration name (e.g., 'create_users_table')
     * @param string $path Directory to create migration in
     * @param string|null $table Optional table name
     * @param bool $create Whether this is a table creation migration
     *
     * @return string Path to created migration file
     */
    public function create(string $name, string $path, ?string $table = null, bool $create = false): string;

    /**
     * Get the migration stub file content.
     *
     * @param string|null $table Optional table name
     * @param bool $create Whether this is a table creation migration
     *
     * @return string The stub content
     */
    public function getStub(?string $table = null, bool $create = false): string;

    /**
     * Populate the stub with actual values.
     *
     * @param string $stub The stub content
     * @param string $name Migration name
     * @param string|null $table Optional table name
     *
     * @return string Populated stub content
     */
    public function populateStub(string $stub, string $name, ?string $table = null): string;

    /**
     * Get the class name for a migration.
     *
     * @param string $name Migration name
     *
     * @return string The class name
     */
    public function getClassName(string $name): string;

    /**
     * Get the date prefix for migration file.
     *
     * @return string Timestamp prefix (e.g., '2025_10_19_120000')
     */
    public function getDatePrefix(): string;

    /**
     * Get the full migration file name.
     *
     * @param string $name Migration name
     *
     * @return string The migration file name with timestamp
     */
    public function getFileName(string $name): string;

    /**
     * Set custom stub path.
     *
     * @param string $path Path to custom stub files
     *
     * @return self
     */
    public function setCustomStubPath(string $path): self;
}
