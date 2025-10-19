<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Event;

use Flaphl\Fridge\Precept\Entity\EntityInterface;

/**
 * Base lifecycle event.
 */
interface LifecycleEventInterface
{
    /**
     * Get the entity.
     *
     * @return EntityInterface The entity
     */
    public function getEntity(): EntityInterface;

    /**
     * Get the entity class name.
     *
     * @return string The class name
     */
    public function getEntityClassName(): string;
}
