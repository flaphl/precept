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
 * Defines a one-to-one relationship.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class OneToOne
{
    public function __construct(
        public readonly string $targetEntity,
        public readonly ?string $mappedBy = null,
        public readonly ?string $inversedBy = null,
        public readonly array $cascade = [],
        public readonly ?string $fetch = 'LAZY',
        public readonly bool $orphanRemoval = false,
    ) {
    }
}
