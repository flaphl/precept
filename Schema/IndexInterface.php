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
 * Index definition interface.
 */
interface IndexInterface
{
    /**
     * Get the index name.
     *
     * @return string The name
     */
    public function getName(): string;

    /**
     * Get columns in the index.
     *
     * @return array<string> Column names
     */
    public function getColumns(): array;

    /**
     * Check if primary key.
     *
     * @return bool True if primary
     */
    public function isPrimary(): bool;

    /**
     * Check if unique index.
     *
     * @return bool True if unique
     */
    public function isUnique(): bool;

    /**
     * Get index options.
     *
     * @return array<string, mixed> The options
     */
    public function getOptions(): array;
}
