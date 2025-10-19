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
 * Exception thrown when there's a mapping configuration error.
 */
class MappingException extends PreceptException
{
    /**
     * Create exception for unknown entity.
     *
     * @param string $entityClass The unknown entity class
     *
     * @return static
     */
    public static function unknownEntity(string $entityClass): static
    {
        return new static(
            sprintf('Entity class "%s" is not recognized or has no metadata mapping.', $entityClass)
        );
    }

    /**
     * Create exception for missing identifier.
     *
     * @param string $entityClass The entity class
     *
     * @return static
     */
    public static function missingIdentifier(string $entityClass): static
    {
        return new static(
            sprintf('Entity "%s" has no identifier defined. Use #[Id] attribute.', $entityClass)
        );
    }

    /**
     * Create exception for invalid field mapping.
     *
     * @param string $entityClass The entity class
     * @param string $fieldName The field name
     * @param string $reason The reason for the error
     *
     * @return static
     */
    public static function invalidFieldMapping(string $entityClass, string $fieldName, string $reason): static
    {
        return new static(
            sprintf(
                'Invalid mapping for field "%s" in entity "%s": %s',
                $fieldName,
                $entityClass,
                $reason
            )
        );
    }

    /**
     * Create exception for invalid association mapping.
     *
     * @param string $entityClass The entity class
     * @param string $fieldName The field name
     * @param string $reason The reason for the error
     *
     * @return static
     */
    public static function invalidAssociationMapping(string $entityClass, string $fieldName, string $reason): static
    {
        return new static(
            sprintf(
                'Invalid association mapping for "%s" in entity "%s": %s',
                $fieldName,
                $entityClass,
                $reason
            )
        );
    }
}
