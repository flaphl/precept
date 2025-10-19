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
 * Table definition interface.
 */
interface TableInterface
{
    /**
     * Get the table name.
     *
     * @return string The name
     */
    public function getName(): string;

    /**
     * Add a column.
     *
     * @param ColumnInterface $column The column
     *
     * @return self
     */
    public function addColumn(ColumnInterface $column): self;

    /**
     * Get all columns.
     *
     * @return array<ColumnInterface> The columns
     */
    public function getColumns(): array;

    /**
     * Get a column by name.
     *
     * @param string $name The column name
     *
     * @return ColumnInterface The column
     */
    public function getColumn(string $name): ColumnInterface;

    /**
     * Check if column exists.
     *
     * @param string $name The column name
     *
     * @return bool True if exists
     */
    public function hasColumn(string $name): bool;

    /**
     * Set primary key.
     *
     * @param array<string> $columnNames Column names
     * @param string|null $indexName Optional index name
     *
     * @return self
     */
    public function setPrimaryKey(array $columnNames, ?string $indexName = null): self;

    /**
     * Get primary key.
     *
     * @return IndexInterface|null The primary key index
     */
    public function getPrimaryKey(): ?IndexInterface;

    /**
     * Add an index.
     *
     * @param IndexInterface $index The index
     *
     * @return self
     */
    public function addIndex(IndexInterface $index): self;

    /**
     * Get all indexes.
     *
     * @return array<IndexInterface> The indexes
     */
    public function getIndexes(): array;

    /**
     * Add a foreign key.
     *
     * @param ForeignKeyInterface $foreignKey The foreign key
     *
     * @return self
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey): self;

    /**
     * Get all foreign keys.
     *
     * @return array<ForeignKeyInterface> The foreign keys
     */
    public function getForeignKeys(): array;

    /**
     * Set table options.
     *
     * @param array<string, mixed> $options The options
     *
     * @return self
     */
    public function setOptions(array $options): self;

    /**
     * Get table options.
     *
     * @return array<string, mixed> The options
     */
    public function getOptions(): array;
}
