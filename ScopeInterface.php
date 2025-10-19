<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept;

use Flaphl\Fridge\Precept\Query\QueryBuilderInterface;

/**
 * Query scope interface for applying reusable query constraints.
 * 
 * Scopes allow you to define common query constraints that can be
 * reused throughout your application. They can be applied globally
 * to all queries for an entity or applied on-demand.
 */
interface ScopeInterface
{
    /**
     * Apply the scope to a given query builder.
     *
     * @param QueryBuilderInterface $builder The query builder
     * @param string $entityClass The entity class being queried
     *
     * @return void
     */
    public function apply(QueryBuilderInterface $builder, string $entityClass): void;

    /**
     * Remove the scope from a given query builder.
     * 
     * This allows temporarily disabling a global scope.
     *
     * @param QueryBuilderInterface $builder The query builder
     * @param string $entityClass The entity class being queried
     *
     * @return void
     */
    public function remove(QueryBuilderInterface $builder, string $entityClass): void;

    /**
     * Get the scope identifier.
     *
     * @return string The unique scope identifier
     */
    public function getName(): string;
}
