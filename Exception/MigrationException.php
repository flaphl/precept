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
 * Exception thrown when a migration operation fails.
 */
class MigrationException extends PreceptException
{
    /**
     * Create exception for migration not found.
     *
     * @param string $name Migration name
     *
     * @return self
     */
    public static function notFound(string $name): self
    {
        return new self(sprintf('Migration "%s" not found.', $name));
    }

    /**
     * Create exception for migration already exists.
     *
     * @param string $name Migration name
     *
     * @return self
     */
    public static function alreadyExists(string $name): self
    {
        return new self(sprintf('Migration "%s" already exists.', $name));
    }

    /**
     * Create exception for migration execution failure.
     *
     * @param string $name Migration name
     * @param \Throwable $previous Previous exception
     *
     * @return self
     */
    public static function executionFailed(string $name, \Throwable $previous): self
    {
        return new self(
            sprintf('Migration "%s" execution failed: %s', $name, $previous->getMessage()),
            0,
            $previous
        );
    }

    /**
     * Create exception for migration rollback failure.
     *
     * @param string $name Migration name
     * @param \Throwable $previous Previous exception
     *
     * @return self
     */
    public static function rollbackFailed(string $name, \Throwable $previous): self
    {
        return new self(
            sprintf('Migration "%s" rollback failed: %s', $name, $previous->getMessage()),
            0,
            $previous
        );
    }

    /**
     * Create exception for invalid migration file.
     *
     * @param string $file File path
     * @param string $reason Reason for invalidity
     *
     * @return self
     */
    public static function invalidFile(string $file, string $reason): self
    {
        return new self(sprintf('Invalid migration file "%s": %s', $file, $reason));
    }

    /**
     * Create exception for repository not found.
     *
     * @return self
     */
    public static function repositoryNotFound(): self
    {
        return new self('Migration repository does not exist. Run migrations:install first.');
    }

    /**
     * Create exception for nothing to migrate.
     *
     * @return self
     */
    public static function nothingToMigrate(): self
    {
        return new self('Nothing to migrate.');
    }

    /**
     * Create exception for nothing to rollback.
     *
     * @return self
     */
    public static function nothingToRollback(): self
    {
        return new self('Nothing to rollback.');
    }
}
