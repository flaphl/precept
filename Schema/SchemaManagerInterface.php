<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Schema;

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;

/**
 * Schema manager interface.
 */
interface SchemaManagerInterface
{
    /**
     * Get the connection.
     *
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface;

    /**
     * Get all table names.
     *
     * @return array<string> Table names
     */
    public function listTableNames(): array;

    /**
     * Check if a table exists.
     *
     * @param string $tableName The table name
     *
     * @return bool True if exists
     */
    public function tableExists(string $tableName): bool;

    /**
     * Create a table.
     *
     * @param TableInterface $table The table definition
     *
     * @return void
     */
    public function createTable(TableInterface $table): void;

    /**
     * Drop a table.
     *
     * @param string $tableName The table name
     *
     * @return void
     */
    public function dropTable(string $tableName): void;

    /**
     * Alter a table.
     *
     * @param string $tableName The table name
     * @param TableDiffInterface $diff The differences to apply
     *
     * @return void
     */
    public function alterTable(string $tableName, TableDiffInterface $diff): void;

    /**
     * Get table details.
     *
     * @param string $tableName The table name
     *
     * @return TableInterface The table definition
     */
    public function getTable(string $tableName): TableInterface;

    /**
     * Get column details for a table.
     *
     * @param string $tableName The table name
     *
     * @return array<ColumnInterface> The columns
     */
    public function listTableColumns(string $tableName): array;

    /**
     * Get indexes for a table.
     *
     * @param string $tableName The table name
     *
     * @return array<IndexInterface> The indexes
     */
    public function listTableIndexes(string $tableName): array;

    /**
     * Get foreign keys for a table.
     *
     * @param string $tableName The table name
     *
     * @return array<ForeignKeyInterface> The foreign keys
     */
    public function listTableForeignKeys(string $tableName): array;

    /**
     * Create the schema from entity metadata.
     *
     * @param array<string> $entityClasses Entity class names
     *
     * @return void
     */
    public function createSchema(array $entityClasses): void;

    /**
     * Update the schema from entity metadata.
     *
     * @param array<string> $entityClasses Entity class names
     * @param bool $saveMode Whether to preserve existing data
     *
     * @return void
     */
    public function updateSchema(array $entityClasses, bool $saveMode = true): void;

    /**
     * Drop the schema.
     *
     * @param array<string> $entityClasses Entity class names
     *
     * @return void
     */
    public function dropSchema(array $entityClasses): void;
}
