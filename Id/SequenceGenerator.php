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

/**
 * Sequence generator for database sequences (PostgreSQL, Oracle, etc.).
 * Generates IDs using a database sequence before INSERT.
 */
class SequenceGenerator extends AbstractIdGenerator
{
    public function __construct(
        \Flaphl\Fridge\Precept\Connection\ConnectionInterface $connection,
        private readonly string $sequenceName,
        private readonly int $allocationSize = 1
    ) {
        parent::__construct($connection);
    }

    public function generate(object $entity): mixed
    {
        // Get next value from sequence
        $sql = sprintf("SELECT nextval('%s')", $this->sequenceName);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_NUM);

        return $result[0] ?? null;
    }

    public function isPostInsertGenerator(): bool
    {
        // Sequence generators generate ID before insert
        return false;
    }

    public function getName(): string
    {
        return 'sequence';
    }

    /**
     * Get the sequence name.
     */
    public function getSequenceName(): string
    {
        return $this->sequenceName;
    }

    /**
     * Get the allocation size for batch ID generation.
     */
    public function getAllocationSize(): int
    {
        return $this->allocationSize;
    }

    /**
     * Generate multiple IDs in batch for performance.
     *
     * @return int[]
     */
    public function generateBatch(int $count): array
    {
        if ($count <= 0) {
            return [];
        }

        $ids = [];
        $sql = sprintf("SELECT nextval('%s')", $this->sequenceName);

        for ($i = 0; $i < $count; $i++) {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_NUM);
            $ids[] = $result[0];
        }

        return $ids;
    }
}
