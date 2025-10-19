<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Mapping;

/**
 * Marks a polymorphic relationship (morphTo).
 * 
 * Represents a polymorphic relationship where this entity can belong to
 * multiple different entity types. Uses type and id columns to determine
 * the related entity class and identifier.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class MorphTo
{
    /**
     * @param string|null $name The morph relation name
     * @param string|null $type The type column name (stores entity class)
     * @param string|null $id The id column name (stores entity id)
     * @param array<string> $cascade Cascade operations
     * @param string $fetch Fetch strategy: LAZY or EAGER
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $id = null,
        public readonly array $cascade = [],
        public readonly string $fetch = 'LAZY',
    ) {
    }
}
