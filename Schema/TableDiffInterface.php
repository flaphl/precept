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

/**
 * Table difference interface for schema migrations.
 */
interface TableDiffInterface
{
    /**
     * Get the table name.
     *
     * @return string The name
     */
    public function getTableName(): string;

    /**
     * Get added columns.
     *
     * @return array<ColumnInterface> The columns
     */
    public function getAddedColumns(): array;

    /**
     * Get changed columns.
     *
     * @return array<string, ColumnInterface> Column name => new definition
     */
    public function getChangedColumns(): array;

    /**
     * Get removed columns.
     *
     * @return array<string> Column names
     */
    public function getRemovedColumns(): array;

    /**
     * Get added indexes.
     *
     * @return array<IndexInterface> The indexes
     */
    public function getAddedIndexes(): array;

    /**
     * Get removed indexes.
     *
     * @return array<string> Index names
     */
    public function getRemovedIndexes(): array;

    /**
     * Get added foreign keys.
     *
     * @return array<ForeignKeyInterface> The foreign keys
     */
    public function getAddedForeignKeys(): array;

    /**
     * Get removed foreign keys.
     *
     * @return array<string> Foreign key names
     */
    public function getRemovedForeignKeys(): array;

    /**
     * Get renamed columns.
     *
     * @return array<string, string> Old name => new name
     */
    public function getRenamedColumns(): array;
}
