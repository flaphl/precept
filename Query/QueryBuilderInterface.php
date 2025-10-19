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

use Flaphl\Fridge\Precept\Entity\EntityInterface;

/**
 * Query builder interface for constructing database queries.
 */
interface QueryBuilderInterface
{
    /**
     * Select fields.
     *
     * @param string ...$fields The fields to select
     *
     * @return self
     */
    public function select(string ...$fields): self;

    /**
     * Add a from clause.
     *
     * @param class-string<EntityInterface> $entityClass The entity class
     * @param string $alias The entity alias
     *
     * @return self
     */
    public function from(string $entityClass, string $alias): self;

    /**
     * Add a where condition.
     *
     * @param string $condition The where condition
     * @param mixed ...$parameters Condition parameters
     *
     * @return self
     */
    public function where(string $condition, mixed ...$parameters): self;

    /**
     * Add an AND where condition.
     *
     * @param string $condition The condition
     * @param mixed ...$parameters Condition parameters
     *
     * @return self
     */
    public function andWhere(string $condition, mixed ...$parameters): self;

    /**
     * Add an OR where condition.
     *
     * @param string $condition The condition
     * @param mixed ...$parameters Condition parameters
     *
     * @return self
     */
    public function orWhere(string $condition, mixed ...$parameters): self;

    /**
     * Add an order by clause.
     *
     * @param string $field The field to order by
     * @param string $direction ASC or DESC
     *
     * @return self
     */
    public function orderBy(string $field, string $direction = 'ASC'): self;

    /**
     * Add a group by clause.
     *
     * @param string ...$fields The fields to group by
     *
     * @return self
     */
    public function groupBy(string ...$fields): self;

    /**
     * Add a having clause.
     *
     * @param string $condition The having condition
     * @param mixed ...$parameters Condition parameters
     *
     * @return self
     */
    public function having(string $condition, mixed ...$parameters): self;

    /**
     * Set the maximum number of results.
     *
     * @param int $limit The limit
     *
     * @return self
     */
    public function setMaxResults(int $limit): self;

    /**
     * Set the result offset.
     *
     * @param int $offset The offset
     *
     * @return self
     */
    public function setFirstResult(int $offset): self;

    /**
     * Add a join.
     *
     * @param string $join The join expression
     * @param string $alias The alias
     *
     * @return self
     */
    public function join(string $join, string $alias): self;

    /**
     * Add a left join.
     *
     * @param string $join The join expression
     * @param string $alias The alias
     *
     * @return self
     */
    public function leftJoin(string $join, string $alias): self;

    /**
     * Add an inner join.
     *
     * @param string $join The join expression
     * @param string $alias The alias
     *
     * @return self
     */
    public function innerJoin(string $join, string $alias): self;

    /**
     * Set a query parameter.
     *
     * @param string|int $key The parameter key
     * @param mixed $value The parameter value
     *
     * @return self
     */
    public function setParameter(string|int $key, mixed $value): self;

    /**
     * Set multiple query parameters.
     *
     * @param array<string|int, mixed> $parameters The parameters
     *
     * @return self
     */
    public function setParameters(array $parameters): self;

    /**
     * Get the query.
     *
     * @return QueryInterface The query instance
     */
    public function getQuery(): QueryInterface;

    /**
     * Execute and get the result.
     *
     * @return array<EntityInterface> The query results
     */
    public function getResult(): array;

    /**
     * Execute and get a single result.
     *
     * @return EntityInterface|null The single result or null
     */
    public function getSingleResult(): ?EntityInterface;

    /**
     * Execute and get a single scalar result.
     *
     * @return mixed The scalar result
     */
    public function getSingleScalarResult(): mixed;
}
