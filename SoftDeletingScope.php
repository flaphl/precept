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
 * Scope implementation for soft delete functionality.
 * 
 * Automatically adds WHERE deleted_at IS NULL constraints to queries
 * to exclude soft-deleted entities from results.
 */
class SoftDeletingScope implements ScopeInterface
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array<string, \Closure>
     */
    protected array $extensions = [];

    /**
     * Create a new soft deleting scope instance.
     */
    public function __construct()
    {
        $this->extensions = [
            'WithTrashed' => function (QueryBuilderInterface $builder): void {
                $this->remove($builder, '');
            },
            'OnlyTrashed' => function (QueryBuilderInterface $builder): void {
                $this->remove($builder, '');
                $builder->whereNotNull($this->getDeletedAtColumn($builder));
            },
            'WithoutTrashed' => function (QueryBuilderInterface $builder): void {
                $this->apply($builder, '');
            },
        ];
    }

    /**
     * Apply the scope to a given query builder.
     *
     * @param QueryBuilderInterface $builder The query builder
     * @param string $entityClass The entity class being queried
     *
     * @return void
     */
    public function apply(QueryBuilderInterface $builder, string $entityClass): void
    {
        $builder->whereNull($this->getDeletedAtColumn($builder));
    }

    /**
     * Remove the scope from a given query builder.
     *
     * @param QueryBuilderInterface $builder The query builder
     * @param string $entityClass The entity class being queried
     *
     * @return void
     */
    public function remove(QueryBuilderInterface $builder, string $entityClass): void
    {
        $query = $builder->getQuery();

        foreach ($query->wheres ?? [] as $key => $where) {
            if ($this->isSoftDeleteConstraint($where)) {
                unset($query->wheres[$key]);
            }
        }
    }

    /**
     * Get the scope identifier.
     *
     * @return string The unique scope identifier
     */
    public function getName(): string
    {
        return 'soft_deleting';
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param QueryBuilderInterface $builder The query builder
     *
     * @return void
     */
    public function extend(QueryBuilderInterface $builder): void
    {
        foreach ($this->extensions as $extension => $callback) {
            $builder->macro($extension, $callback);
        }
    }

    /**
     * Get the "deleted at" column for the builder.
     *
     * @param QueryBuilderInterface $builder The query builder
     *
     * @return string
     */
    protected function getDeletedAtColumn(QueryBuilderInterface $builder): string
    {
        if (method_exists($builder, 'getModel')) {
            $model = $builder->getModel();
            
            if (method_exists($model, 'getDeletedAtColumn')) {
                return $model->getQualifiedDeletedAtColumn();
            }
        }

        return 'deleted_at';
    }

    /**
     * Determine if the given where clause is a soft delete constraint.
     *
     * @param array<string, mixed> $where The where clause
     *
     * @return bool
     */
    protected function isSoftDeleteConstraint(array $where): bool
    {
        return isset($where['type']) 
            && $where['type'] === 'Null'
            && str_ends_with($where['column'] ?? '', 'deleted_at');
    }
}
