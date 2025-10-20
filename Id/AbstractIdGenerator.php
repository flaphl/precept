<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Id;

use Flaphl\Fridge\Precept\Connection\ConnectionInterface;

/**
 * Abstract base class for ID generators.
 */
abstract class AbstractIdGenerator
{
    public function __construct(
        protected readonly ConnectionInterface $connection
    ) {
    }

    /**
     * Generate a new ID for an entity.
     */
    abstract public function generate(object $entity): mixed;

    /**
     * Check if this generator is post-insert (ID generated after INSERT).
     * Post-insert generators need the database to assign the ID.
     */
    abstract public function isPostInsertGenerator(): bool;

    /**
     * Get the generator name for identification.
     */
    abstract public function getName(): string;
}
