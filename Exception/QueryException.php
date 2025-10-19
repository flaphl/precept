<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Exception;

/**
 * Exception thrown when there's a query builder error.
 */
class QueryException extends PreceptException
{
    /**
     * Create exception for invalid query.
     *
     * @param string $message The error message
     * @param \Throwable|null $previous The previous exception
     *
     * @return static
     */
    public static function invalidQuery(string $message, ?\Throwable $previous = null): static
    {
        return new static(sprintf('Invalid query: %s', $message), 0, $previous);
    }

    /**
     * Create exception for SQL execution error.
     *
     * @param string $sql The SQL statement
     * @param \Throwable $previous The database exception
     *
     * @return static
     */
    public static function executionFailed(string $sql, \Throwable $previous): static
    {
        return new static(
            sprintf('Query execution failed: %s', $sql),
            0,
            $previous
        );
    }

    /**
     * Create exception for non-unique result.
     *
     * @param int $count The number of results found
     *
     * @return static
     */
    public static function nonUniqueResult(int $count): static
    {
        return new static(
            sprintf('Expected exactly one result, but got %d.', $count)
        );
    }
}
