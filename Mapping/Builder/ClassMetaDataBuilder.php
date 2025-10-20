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
 * Fluent builder for class metadata configuration.
 * Provides a programmatic way to define entity mappings.
 */
class ClassMetaDataBuilder
{
    private array $fieldMappings = [];
    private array $associationMappings = [];
    private array $lifecycleCallbacks = [];
    private ?string $tableName = null;
    private ?string $repositoryClass = null;
    private bool $readOnly = false;
    private array $identifierFields = [];
    private ?array $cacheConfig = null;

    public function __construct(
        private readonly string $className
    ) {
    }

    /**
     * Set the table name.
     */
    public function setTable(string $tableName, ?string $schema = null): self
    {
        $this->tableName = $schema ? "$schema.$tableName" : $tableName;

        return $this;
    }

    /**
     * Set the repository class.
     */
    public function setRepositoryClass(string $repositoryClass): self
    {
        $this->repositoryClass = $repositoryClass;

        return $this;
    }

    /**
     * Mark entity as read-only.
     */
    public function setReadOnly(bool $readOnly = true): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Create a field builder.
     */
    public function createField(string $fieldName): FieldBuilder
    {
        return new FieldBuilder($this, $fieldName);
    }

    /**
     * Add a field mapping directly.
     */
    public function addFieldMapping(string $fieldName, array $mapping): self
    {
        $this->fieldMappings[$fieldName] = $mapping;

        return $this;
    }

    /**
     * Set identifier field(s).
     */
    public function setIdentifier(string|array $fieldNames, string $strategy = 'AUTO'): self
    {
        $fields = is_array($fieldNames) ? $fieldNames : [$fieldNames];

        foreach ($fields as $field) {
            $this->identifierFields[] = $field;

            if (!isset($this->fieldMappings[$field])) {
                $this->fieldMappings[$field] = [
                    'fieldName' => $field,
                    'type' => 'integer',
                    'id' => true,
                    'strategy' => $strategy,
                ];
            } else {
                $this->fieldMappings[$field]['id'] = true;
                $this->fieldMappings[$field]['strategy'] = $strategy;
            }
        }

        return $this;
    }

    /**
     * Create a one-to-many association builder.
     */
    public function createOneToMany(string $fieldName, string $targetEntity): OneToManyAssociationBuilder
    {
        return new OneToManyAssociationBuilder($this, $fieldName, $targetEntity);
    }

    /**
     * Create a many-to-many association builder.
     */
    public function createManyToMany(string $fieldName, string $targetEntity): ManyToManyAssociationBuilder
    {
        return new ManyToManyAssociationBuilder($this, $fieldName, $targetEntity);
    }

    /**
     * Add an association mapping directly.
     */
    public function addAssociationMapping(string $fieldName, array $mapping): self
    {
        $this->associationMappings[$fieldName] = $mapping;

        return $this;
    }

    /**
     * Create an entity listener builder.
     */
    public function createEntityListeners(): EntityListenerBuilder
    {
        return new EntityListenerBuilder($this);
    }

    /**
     * Set lifecycle callbacks directly.
     */
    public function setLifecycleCallbacks(array $callbacks): self
    {
        $this->lifecycleCallbacks = array_merge($this->lifecycleCallbacks, $callbacks);

        return $this;
    }

    /**
     * Configure caching.
     */
    public function setCache(string $usage, ?string $region = null, ?int $ttl = null): self
    {
        $this->cacheConfig = [
            'usage' => $usage,
            'region' => $region,
            'ttl' => $ttl,
        ];

        return $this;
    }

    /**
     * Build the metadata array.
     */
    public function build(): array
    {
        $metadata = [
            'className' => $this->className,
            'tableName' => $this->tableName ?? $this->inferTableName(),
            'repositoryClass' => $this->repositoryClass,
            'readOnly' => $this->readOnly,
            'identifier' => $this->identifierFields,
            'fields' => $this->fieldMappings,
            'associations' => $this->associationMappings,
            'lifecycleCallbacks' => $this->lifecycleCallbacks,
        ];

        if ($this->cacheConfig !== null) {
            $metadata['cache'] = $this->cacheConfig;
        }

        return $metadata;
    }

    /**
     * Get the class name.
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Infer table name from class name.
     */
    private function inferTableName(): string
    {
        $className = substr($this->className, strrpos($this->className, '\\') + 1);

        // Convert PascalCase to snake_case
        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));

        // Pluralize (simple version)
        return $tableName . 's';
    }
}
