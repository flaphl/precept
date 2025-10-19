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
 * Query result interface.
 */
interface ResultInterface extends \IteratorAggregate, \Countable
{
    /**
     * Fetch the next row as an associative array.
     *
     * @return array<string, mixed>|false The row or false if no more rows
     */
    public function fetchAssociative(): array|false;

    /**
     * Fetch all rows as associative arrays.
     *
     * @return array<array<string, mixed>> All rows
     */
    public function fetchAllAssociative(): array;

    /**
     * Fetch the next row as a numeric array.
     *
     * @return array<mixed>|false The row or false if no more rows
     */
    public function fetchNumeric(): array|false;

    /**
     * Fetch a single column from the next row.
     *
     * @return mixed The column value or false
     */
    public function fetchOne(): mixed;

    /**
     * Fetch all rows as a single column.
     *
     * @return array<mixed> Column values
     */
    public function fetchFirstColumn(): array;

    /**
     * Get the number of rows.
     *
     * @return int Row count
     */
    public function rowCount(): int;

    /**
     * Free the result resources.
     *
     * @return void
     */
    public function free(): void;
}
