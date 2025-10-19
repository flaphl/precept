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
 * Defines the join column for a relationship.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class JoinColumn
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $referencedColumnName = 'id',
        public readonly bool $nullable = true,
        public readonly bool $unique = false,
        public readonly ?string $onDelete = null,
    ) {
    }
}
