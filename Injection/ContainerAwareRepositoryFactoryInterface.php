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
use Flaphl\Fridge\Precept\Repository\RepositoryInterface;

/**
 * Container-aware repository factory.
 */
interface ContainerAwareRepositoryFactoryInterface
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
     * Create a repository with container injection.
     *
     * @template T of \Flaphl\Fridge\Precept\Entity\EntityInterface
     * @param class-string<T> $entityClass The entity class
     * @param string|null $repositoryClass Optional custom repository class
     *
     * @return RepositoryInterface<T> The repository
     */
    public function createRepository(string $entityClass, ?string $repositoryClass = null): RepositoryInterface;

    /**
     * Resolve repository dependencies from container.
     *
     * @param string $repositoryClass The repository class
     *
     * @return array<mixed> Constructor arguments
     */
    public function resolveRepositoryDependencies(string $repositoryClass): array;
}
