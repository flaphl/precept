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
 * Entity metadata interface.
 */
interface MetadataInterface
{
    /**
     * Get the entity class name.
     *
     * @return string The class name
     */
    public function getClassName(): string;

    /**
     * Get the table name.
     *
     * @return string The table name
     */
    public function getTableName(): string;

    /**
     * Get the repository class.
     *
     * @return string|null The repository class
     */
    public function getRepositoryClass(): ?string;

    /**
     * Check if entity is read-only.
     *
     * @return bool True if read-only
     */
    public function isReadOnly(): bool;

    /**
     * Get field mappings.
     *
     * @return array<string, array<string, mixed>> Field => mapping
     */
    public function getFieldMappings(): array;

    /**
     * Get a field mapping.
     *
     * @param string $fieldName The field name
     *
     * @return array<string, mixed> The mapping
     */
    public function getFieldMapping(string $fieldName): array;

    /**
     * Check if field exists.
     *
     * @param string $fieldName The field name
     *
     * @return bool True if exists
     */
    public function hasField(string $fieldName): bool;

    /**
     * Get identifier field names.
     *
     * @return array<string> Field names
     */
    public function getIdentifierFieldNames(): array;

    /**
     * Get association mappings.
     *
     * @return array<string, array<string, mixed>> Association => mapping
     */
    public function getAssociationMappings(): array;

    /**
     * Get an association mapping.
     *
     * @param string $fieldName The field name
     *
     * @return array<string, mixed> The mapping
     */
    public function getAssociationMapping(string $fieldName): array;

    /**
     * Check if field is an association.
     *
     * @param string $fieldName The field name
     *
     * @return bool True if association
     */
    public function hasAssociation(string $fieldName): bool;

    /**
     * Get lifecycle callbacks.
     *
     * @return array<string, array<string>> Event => methods
     */
    public function getLifecycleCallbacks(): array;
}
