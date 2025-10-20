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
 * Fluent builder for field metadata configuration.
 */
class FieldBuilder
{
    private array $mapping = [];

    public function __construct(
        private readonly ClassMetaDataBuilder $classMetadataBuilder,
        private readonly string $fieldName
    ) {
        $this->mapping['fieldName'] = $fieldName;
    }

    /**
     * Set the column name.
     */
    public function columnName(string $columnName): self
    {
        $this->mapping['columnName'] = $columnName;

        return $this;
    }

    /**
     * Set the field type.
     */
    public function type(string $type): self
    {
        $this->mapping['type'] = $type;

        return $this;
    }

    /**
     * Set if the field is nullable.
     */
    public function nullable(bool $nullable = true): self
    {
        $this->mapping['nullable'] = $nullable;

        return $this;
    }

    /**
     * Set if the field is unique.
     */
    public function unique(bool $unique = true): self
    {
        $this->mapping['unique'] = $unique;

        return $this;
    }

    /**
     * Set the field length.
     */
    public function length(int $length): self
    {
        $this->mapping['length'] = $length;

        return $this;
    }

    /**
     * Set precision for decimal fields.
     */
    public function precision(int $precision): self
    {
        $this->mapping['precision'] = $precision;

        return $this;
    }

    /**
     * Set scale for decimal fields.
     */
    public function scale(int $scale): self
    {
        $this->mapping['scale'] = $scale;

        return $this;
    }

    /**
     * Set default value.
     */
    public function defaultValue(mixed $value): self
    {
        $this->mapping['default'] = $value;

        return $this;
    }

    /**
     * Set column options.
     */
    public function options(array $options): self
    {
        $this->mapping['options'] = $options;

        return $this;
    }

    /**
     * Mark field as generated value (auto-increment).
     */
    public function generatedValue(string $strategy = 'AUTO'): self
    {
        $this->mapping['generated'] = $strategy;

        return $this;
    }

    /**
     * Build and return to class metadata builder.
     */
    public function build(): ClassMetaDataBuilder
    {
        $this->classMetadataBuilder->addFieldMapping($this->fieldName, $this->mapping);

        return $this->classMetadataBuilder;
    }
}
