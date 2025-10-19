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

/**
 * Factory interface for creating entity managers from container.
 */
interface EntityManagerFactoryInterface
{
    /**
     * Create an entity manager from container configuration.
     *
     * @param ContainerInterface $container The DI container
     * @param array<string, mixed> $configuration Entity manager configuration
     *
     * @return ContainerAwareEntityManagerInterface The entity manager
     */
    public function create(ContainerInterface $container, array $configuration = []): ContainerAwareEntityManagerInterface;

    /**
     * Create a named entity manager.
     *
     * @param string $name The entity manager name
     * @param ContainerInterface $container The DI container
     * @param array<string, mixed> $configuration Entity manager configuration
     *
     * @return ContainerAwareEntityManagerInterface The entity manager
     */
    public function createNamed(string $name, ContainerInterface $container, array $configuration = []): ContainerAwareEntityManagerInterface;

    /**
     * Get configuration for an entity manager.
     *
     * @param string $name The entity manager name
     *
     * @return array<string, mixed> The configuration
     */
    public function getConfiguration(string $name): array;
}
