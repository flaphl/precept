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
 * Marks a property as the primary identifier.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Id
{
    public function __construct(
        public readonly ?string $strategy = 'auto',
    ) {
    }
}
