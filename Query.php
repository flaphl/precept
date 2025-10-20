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

use Flaphl\Fridge\Precept\Entity\EntityInterface;
use Flaphl\Fridge\Precept\Query\HydrationMode;
use Flaphl\Fridge\Precept\Query\QueryInterface;
use Flaphl\Fridge\Precept\Exception\QueryException;

/**
 * Query implementation for executing database queries.
 */
class Query extends AbstractQuery implements QueryInterface
{
    private ?string $entityClass = null;

    public function __construct(
        \Flaphl\Fridge\Precept\Connection\ConnectionInterface $connection,
        private string $sql,
        ?\Flaphl\Fridge\Precept\Hydration\HydrationInterface $hydrator = null,
        ?string $entityClass = null
    ) {
        parent::__construct($connection, $hydrator);
        $this->entityClass = $entityClass;
    }

    public function getSQL(): string
    {
        return $this->sql;
    }

    public function getResult(): array
    {
        $result = $this->executeQuery();

        return match ($this->hydrationMode) {
            HydrationMode::OBJECT => $this->hydrateObjects($result),
            HydrationMode::ARRAY => $result,
            HydrationMode::SCALAR, HydrationMode::SINGLE_SCALAR => $this->extractScalars($result),
        };
    }

    public function getSingleResult(): ?EntityInterface
    {
        $results = $this->getResult();

        if (empty($results)) {
            return null;
        }

        if (count($results) > 1) {
            throw QueryException::nonUniqueResult(count($results));
        }

        $result = $results[0];

        if (!$result instanceof EntityInterface) {
            throw QueryException::invalidResultType(EntityInterface::class, get_debug_type($result));
        }

        return $result;
    }

    public function getSingleScalarResult(): mixed
    {
        $this->setHydrationMode(HydrationMode::SINGLE_SCALAR);
        $results = $this->getResult();

        if (empty($results)) {
            return null;
        }

        return $results[0];
    }

    public function getArrayResult(): array
    {
        $this->setHydrationMode(HydrationMode::ARRAY);

        return $this->getResult();
    }

    public function execute(): mixed
    {
        return $this->getResult();
    }

    /**
     * Execute the query against the database.
     */
    private function executeQuery(): array
    {
        $result = $this->parseQuery();
        $boundParams = $this->getBoundParameters();

        $statement = $this->connection->query($result->getSql(), $boundParams);

        return $statement->fetchAll();
    }

    /**
     * Hydrate results into entity objects.
     */
    private function hydrateObjects(array $results): array
    {
        if ($this->hydrator === null || $this->entityClass === null) {
            return $results;
        }

        return $this->hydrator->hydrateAll($results, $this->entityClass);
    }

    /**
     * Extract scalar values from results.
     */
    private function extractScalars(array $results): array
    {
        return array_map(function ($row) {
            if (is_array($row)) {
                return array_values($row)[0] ?? null;
            }

            return $row;
        }, $results);
    }

    /**
     * Set the entity class for hydration.
     */
    public function setEntityClass(string $entityClass): self
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get the entity class.
     */
    public function getEntityClass(): ?string
    {
        return $this->entityClass;
    }
}
