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
 * Exception thrown when an entity is not found.
 */
class EntityNotFoundException extends PreceptException
{
    /**
     * Create exception for entity not found by identifier.
     *
     * @param string $entityClass The entity class name
     * @param mixed $identifier The identifier that was not found
     *
     * @return static
     */
    public static function fromIdentifier(string $entityClass, mixed $identifier): static
    {
        $id = is_array($identifier) ? json_encode($identifier) : (string) $identifier;
        
        return new static(
            sprintf('Entity "%s" with identifier %s was not found.', $entityClass, $id)
        );
    }

    /**
     * Create exception for entity not found by criteria.
     *
     * @param string $entityClass The entity class name
     * @param array<string, mixed> $criteria The search criteria
     *
     * @return static
     */
    public static function fromCriteria(string $entityClass, array $criteria): static
    {
        return new static(
            sprintf(
                'Entity "%s" matching criteria %s was not found.',
                $entityClass,
                json_encode($criteria)
            )
        );
    }
}
