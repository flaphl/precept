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
 * Exception thrown when there's a transaction error.
 */
class TransactionException extends PreceptException
{
    /**
     * Create exception for no active transaction.
     *
     * @return static
     */
    public static function noActiveTransaction(): static
    {
        return new static('No active transaction to commit or rollback.');
    }

    /**
     * Create exception for nested transaction not supported.
     *
     * @return static
     */
    public static function nestedNotSupported(): static
    {
        return new static('Nested transactions are not supported by this driver.');
    }

    /**
     * Create exception for transaction already active.
     *
     * @return static
     */
    public static function alreadyActive(): static
    {
        return new static('Cannot start a new transaction while one is already active.');
    }

    /**
     * Create exception for commit failure.
     *
     * @param \Throwable $previous The database exception
     *
     * @return static
     */
    public static function commitFailed(\Throwable $previous): static
    {
        return new static('Transaction commit failed.', 0, $previous);
    }

    /**
     * Create exception for rollback failure.
     *
     * @param \Throwable $previous The database exception
     *
     * @return static
     */
    public static function rollbackFailed(\Throwable $previous): static
    {
        return new static('Transaction rollback failed.', 0, $previous);
    }
}
