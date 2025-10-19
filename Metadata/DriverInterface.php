<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Metadata;

/**
 * Metadata driver interface.
 */
interface DriverInterface
{
    /**
     * Load metadata for a class.
     *
     * @param string $className The class name
     *
     * @return MetadataInterface|null The metadata or null
     */
    public function loadMetadataForClass(string $className): ?MetadataInterface;

    /**
     * Get all class names.
     *
     * @return array<string> Class names
     */
    public function getAllClassNames(): array;

    /**
     * Check if driver is transient (non-cacheable).
     *
     * @return bool True if transient
     */
    public function isTransient(): bool;
}
