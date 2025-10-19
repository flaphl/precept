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
 * Migration execution status.
 */
enum MigrationStatus: string
{
    /**
     * Migration has not been run yet.
     */
    case PENDING = 'pending';

    /**
     * Migration has been successfully executed.
     */
    case RAN = 'ran';

    /**
     * Migration execution failed.
     */
    case FAILED = 'failed';

    /**
     * Migration is currently running.
     */
    case RUNNING = 'running';

    /**
     * Get display label for status.
     *
     * @return string Human-readable status
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::RAN => 'Ran',
            self::FAILED => 'Failed',
            self::RUNNING => 'Running',
        };
    }

    /**
     * Check if migration can be executed.
     *
     * @return bool True if status allows execution
     */
    public function canExecute(): bool
    {
        return $this === self::PENDING;
    }

    /**
     * Check if migration can be rolled back.
     *
     * @return bool True if status allows rollback
     */
    public function canRollback(): bool
    {
        return $this === self::RAN;
    }
}
