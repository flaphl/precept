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
 * Specifies the table for an entity.
 *
 * @Annotation
 * @Target("CLASS")
 */
#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $schema = null,
        public readonly array $indexes = [],
        public readonly array $uniqueConstraints = [],
        public readonly array $options = []
    ) {
    }
}
