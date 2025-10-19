<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Connection;

/**
 * Database platform interface.
 */
interface PlatformInterface
{
    /**
     * Get the name of the platform.
     *
     * @return string Platform name (mysql, postgresql, sqlite, etc.)
     */
    public function getName(): string;

    /**
     * Quote an identifier.
     *
     * @param string $identifier The identifier
     *
     * @return string The quoted identifier
     */
    public function quoteIdentifier(string $identifier): string;

    /**
     * Get the SQL for creating a table.
     *
     * @param string $tableName The table name
     * @param array<string, array<string, mixed>> $columns Column definitions
     * @param array<string, mixed> $options Table options
     *
     * @return string The CREATE TABLE SQL
     */
    public function getCreateTableSQL(string $tableName, array $columns, array $options = []): string;

    /**
     * Get the SQL for dropping a table.
     *
     * @param string $tableName The table name
     *
     * @return string The DROP TABLE SQL
     */
    public function getDropTableSQL(string $tableName): string;

    /**
     * Get the SQL for altering a table.
     *
     * @param string $tableName The table name
     * @param array<string, mixed> $changes The changes to apply
     *
     * @return array<string> Array of ALTER TABLE statements
     */
    public function getAlterTableSQL(string $tableName, array $changes): array;

    /**
     * Get the SQL type declaration for a column.
     *
     * @param array<string, mixed> $column Column definition
     *
     * @return string The SQL type
     */
    public function getColumnDeclarationSQL(array $column): string;
}
