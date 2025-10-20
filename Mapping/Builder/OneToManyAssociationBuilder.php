<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Mapping\Builder;

/**
 * Fluent builder for one-to-many association metadata.
 */
class OneToManyAssociationBuilder
{
    private array $mapping = [];

    public function __construct(
        private readonly ClassMetaDataBuilder $classMetadataBuilder,
        private readonly string $fieldName,
        private readonly string $targetEntity
    ) {
        $this->mapping['fieldName'] = $fieldName;
        $this->mapping['targetEntity'] = $targetEntity;
        $this->mapping['type'] = 'oneToMany';
    }

    /**
     * Set the mapped by field (inverse side).
     */
    public function mappedBy(string $mappedBy): self
    {
        $this->mapping['mappedBy'] = $mappedBy;

        return $this;
    }

    /**
     * Set cascade operations.
     */
    public function cascade(array $cascade): self
    {
        $this->mapping['cascade'] = $cascade;

        return $this;
    }

    /**
     * Set orphan removal.
     */
    public function orphanRemoval(bool $orphanRemoval = true): self
    {
        $this->mapping['orphanRemoval'] = $orphanRemoval;

        return $this;
    }

    /**
     * Set fetch mode (LAZY, EAGER).
     */
    public function fetch(string $fetch): self
    {
        $this->mapping['fetch'] = $fetch;

        return $this;
    }

    /**
     * Set index by field.
     */
    public function indexBy(string $indexBy): self
    {
        $this->mapping['indexBy'] = $indexBy;

        return $this;
    }

    /**
     * Set order by.
     */
    public function orderBy(array $orderBy): self
    {
        $this->mapping['orderBy'] = $orderBy;

        return $this;
    }

    /**
     * Build and return to class metadata builder.
     */
    public function build(): ClassMetaDataBuilder
    {
        $this->classMetadataBuilder->addAssociationMapping($this->fieldName, $this->mapping);

        return $this->classMetadataBuilder;
    }
}
