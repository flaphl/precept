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

use Flaphl\Fridge\Precept\Schema\TableInterface;

/**
 * Generates migration files from schema definitions or differences.
 */
interface MigrationGeneratorInterface
{
    /**
     * Generate a migration file from entity classes.
     *
     * @param array<string> $entityClasses Entity class names
     * @param string $name Migration name
     * @param array $options Generation options
     *
     * @return string Path to generated migration file
     */
    public function generateFromEntities(array $entityClasses, string $name, array $options = []): string;

    /**
     * Generate a migration file from schema differences.
     *
     * @param array<TableInterface> $fromSchema Current schema tables
     * @param array<TableInterface> $toSchema Target schema tables
     * @param string $name Migration name
     * @param array $options Generation options
     *
     * @return string Path to generated migration file
     */
    public function generateFromDiff(array $fromSchema, array $toSchema, string $name, array $options = []): string;

    /**
     * Generate a blank migration file.
     *
     * @param string $name Migration name
     * @param array $options Generation options (e.g., 'create', 'table')
     *
     * @return string Path to generated migration file
     */
    public function generateBlank(string $name, array $options = []): string;

    /**
     * Generate migration file content.
     *
     * @param string $name Migration name
     * @param string $upCode PHP code for up() method
     * @param string $downCode PHP code for down() method
     * @param array $options Additional options
     *
     * @return string The migration file content
     */
    public function generateContent(string $name, string $upCode, string $downCode, array $options = []): string;

    /**
     * Set the path where migrations should be generated.
     *
     * @param string $path The migrations directory path
     *
     * @return self
     */
    public function setPath(string $path): self;

    /**
     * Get the migrations directory path.
     *
     * @return string The migrations path
     */
    public function getPath(): string;

    /**
     * Set the namespace for generated migrations.
     *
     * @param string $namespace The migration namespace
     *
     * @return self
     */
    public function setNamespace(string $namespace): self;

    /**
     * Get the migration namespace.
     *
     * @return string The namespace
     */
    public function getNamespace(): string;
}
