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

use Attribute;

/**
 * Specifies a join table for a many-to-many relationship.
 *
 * @Annotation
 * @Target("PROPERTY")
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class JoinTable
{
    public function __construct(
        public readonly string $name,
        public readonly ?array $joinColumns = null,
        public readonly ?array $inverseJoinColumns = null,
        public readonly ?string $schema = null
    ) {
    }
}
