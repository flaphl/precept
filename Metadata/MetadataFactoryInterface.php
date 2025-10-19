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
 * Metadata factory interface.
 */
interface MetadataFactoryInterface
{
    /**
     * Get metadata for an entity class.
     *
     * @param string $className The entity class name
     *
     * @return MetadataInterface The metadata
     */
    public function getMetadataFor(string $className): MetadataInterface;

    /**
     * Check if metadata exists for a class.
     *
     * @param string $className The class name
     *
     * @return bool True if exists
     */
    public function hasMetadataFor(string $className): bool;

    /**
     * Get all loaded metadata.
     *
     * @return array<MetadataInterface> All metadata
     */
    public function getAllMetadata(): array;

    /**
     * Check if a class is an entity.
     *
     * @param string $className The class name
     *
     * @return bool True if entity
     */
    public function isEntity(string $className): bool;
}
