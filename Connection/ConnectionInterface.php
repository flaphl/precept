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
 * Database connection interface.
 */
interface ConnectionInterface
{
    /**
     * Execute a query and return the result.
     *
     * @param string $sql The SQL query
     * @param array<mixed> $params Query parameters
     *
     * @return ResultInterface The query result
     */
    public function query(string $sql, array $params = []): ResultInterface;

    /**
     * Execute a statement and return affected rows.
     *
     * @param string $sql The SQL statement
     * @param array<mixed> $params Statement parameters
     *
     * @return int Number of affected rows
     */
    public function execute(string $sql, array $params = []): int;

    /**
     * Begin a transaction.
     *
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * Commit the current transaction.
     *
     * @return void
     */
    public function commit(): void;

    /**
     * Rollback the current transaction.
     *
     * @return void
     */
    public function rollback(): void;

    /**
     * Check if in a transaction.
     *
     * @return bool True if in a transaction
     */
    public function inTransaction(): bool;

    /**
     * Get the last insert ID.
     *
     * @return string|int The last insert ID
     */
    public function lastInsertId(): string|int;

    /**
     * Prepare a statement.
     *
     * @param string $sql The SQL to prepare
     *
     * @return StatementInterface The prepared statement
     */
    public function prepare(string $sql): StatementInterface;

    /**
     * Quote a value for safe use in SQL.
     *
     * @param mixed $value The value to quote
     *
     * @return string The quoted value
     */
    public function quote(mixed $value): string;

    /**
     * Get the database platform.
     *
     * @return PlatformInterface The database platform
     */
    public function getPlatform(): PlatformInterface;
}
