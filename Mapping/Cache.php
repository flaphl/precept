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
 * Configures caching for an entity or association.
 *
 * @Annotation
 * @Target({"CLASS", "PROPERTY"})
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class Cache
{
    public const READ_ONLY = 'READ_ONLY';
    public const READ_WRITE = 'READ_WRITE';
    public const NONSTRICT_READ_WRITE = 'NONSTRICT_READ_WRITE';

    public function __construct(
        public readonly string $usage = self::READ_ONLY,
        public readonly ?string $region = null,
        public readonly ?int $ttl = null
    ) {
    }
}
