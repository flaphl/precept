<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Injection;

use Flaphl\Element\Injection\ContainerInterface;
use Flaphl\Fridge\Precept\Entity\EntityManagerInterface;
use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Metadata\MetadataFactoryInterface;
use Flaphl\Fridge\Precept\Cache\ResultCacheInterface;

/**
 * Container-aware entity manager interface.
 */
interface ContainerAwareEntityManagerInterface extends EntityManagerInterface
{
    /**
     * Set the service container.
     *
     * @param ContainerInterface $container The DI container
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container): void;

    /**
     * Get the service container.
     *
     * @return ContainerInterface|null The DI container
     */
    public function getContainer(): ?ContainerInterface;

    /**
     * Resolve a service from the container.
     *
     * @param string $id The service identifier
     *
     * @return mixed The resolved service
     */
    public function resolve(string $id): mixed;
}
