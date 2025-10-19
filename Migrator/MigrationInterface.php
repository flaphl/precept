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

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Schema\SchemaManagerInterface;

/**
 * Represents a database migration.
 */
interface MigrationInterface
{
    /**
     * Get the migration name.
     *
     * @return string The unique migration identifier
     */
    public function getName(): string;

    /**
     * Get the migration description.
     *
     * @return string Human-readable description of changes
     */
    public function getDescription(): string;

    /**
     * Execute the migration (upgrade).
     *
     * @param SchemaManagerInterface $schema The schema manager
     * @param ConnectionInterface $connection The database connection
     *
     * @return void
     */
    public function up(SchemaManagerInterface $schema, ConnectionInterface $connection): void;

    /**
     * Reverse the migration (downgrade).
     *
     * @param SchemaManagerInterface $schema The schema manager
     * @param ConnectionInterface $connection The database connection
     *
     * @return void
     */
    public function down(SchemaManagerInterface $schema, ConnectionInterface $connection): void;

    /**
     * Check if this migration is transactional.
     *
     * @return bool True if should run in a transaction
     */
    public function isTransactional(): bool;
}
