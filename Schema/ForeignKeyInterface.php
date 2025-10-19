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
 * Foreign key definition interface.
 */
interface ForeignKeyInterface
{
    /**
     * Get the foreign key name.
     *
     * @return string The name
     */
    public function getName(): string;

    /**
     * Get local columns.
     *
     * @return array<string> Column names
     */
    public function getLocalColumns(): array;

    /**
     * Get foreign table name.
     *
     * @return string The table name
     */
    public function getForeignTableName(): string;

    /**
     * Get foreign columns.
     *
     * @return array<string> Column names
     */
    public function getForeignColumns(): array;

    /**
     * Get on delete action.
     *
     * @return string|null The action (CASCADE, SET NULL, etc.)
     */
    public function getOnDelete(): ?string;

    /**
     * Get on update action.
     *
     * @return string|null The action (CASCADE, SET NULL, etc.)
     */
    public function getOnUpdate(): ?string;
}
