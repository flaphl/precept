<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Query;

/**
 * Hydration mode enumeration.
 */
enum HydrationMode: string
{
    /**
     * Hydrate as entity objects.
     */
    case OBJECT = 'object';

    /**
     * Hydrate as arrays.
     */
    case ARRAY = 'array';

    /**
     * Hydrate as single scalar value.
     */
    case SCALAR = 'scalar';

    /**
     * Hydrate as single column array.
     */
    case SINGLE_SCALAR = 'single_scalar';
}
