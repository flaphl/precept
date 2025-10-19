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

/**
 * Service provider interface for registering ORM services with DI container.
 */
interface ServiceProviderInterface
{
    /**
     * Register ORM services with the container.
     *
     * @param ContainerInterface $container The DI container
     *
     * @return void
     */
    public function register(ContainerInterface $container): void;

    /**
     * Boot the service provider after all services registered.
     *
     * @param ContainerInterface $container The DI container
     *
     * @return void
     */
    public function boot(ContainerInterface $container): void;

    /**
     * Get services provided by this provider.
     *
     * @return array<string> Service identifiers
     */
    public function provides(): array;
}
