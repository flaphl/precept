<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Hydration;

/**
 * Entity instantiator interface.
 */
interface InstantiatorInterface
{
    /**
     * Instantiate an entity without calling the constructor.
     *
     * @param string $className The class name
     *
     * @return object The instance
     */
    public function instantiate(string $className): object;

    /**
     * Check if a class can be instantiated.
     *
     * @param string $className The class name
     *
     * @return bool True if can instantiate
     */
    public function canInstantiate(string $className): bool;
}
