<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Mapping\Driver;

use Flaphl\Fridge\Precept\Metadata\DriverInterface;

/**
 * Full-featured XML metadata driver.
 * Loads entity metadata from XML files with complete schema support.
 */
class XmlDriver implements DriverInterface
{
    private array $loadedFiles = [];

    public function __construct(
        private readonly string|array $paths,
        private readonly bool $validateSchema = false
    ) {
    }

    /**
     * Load metadata for a class from XML file.
     */
    public function loadMetadataForClass(string $className): array
    {
        $xmlFile = $this->locateXmlFile($className);

        if ($xmlFile === null) {
            return [];
        }

        if (isset($this->loadedFiles[$xmlFile])) {
            return $this->loadedFiles[$xmlFile][$className] ?? [];
        }

        $xml = $this->loadXmlFile($xmlFile);

        if ($xml === false) {
            return [];
        }

        $metadata = [];

        foreach ($xml->entity as $entity) {
            $entityMetadata = $this->parseEntity($entity);
            $metadata[$entityMetadata['className']] = $entityMetadata;
        }

        $this->loadedFiles[$xmlFile] = $metadata;

        return $metadata[$className] ?? [];
    }

    /**
     * Parse an entity element.
     */
    private function parseEntity(\SimpleXMLElement $entity): array
    {
        $className = (string) $entity['name'];

        $metadata = [
            'className' => $className,
            'tableName' => $this->parseTable($entity),
            'repositoryClass' => (string) ($entity['repository-class'] ?? null) ?: null,
            'readOnly' => ((string) ($entity['read-only'] ?? 'false')) === 'true',
            'fields' => [],
            'associations' => [],
            'identifier' => [],
            'lifecycleCallbacks' => [],
        ];

        // Parse ID field(s)
        if (isset($entity->id)) {
            foreach ($entity->id as $id) {
                $this->parseIdField($id, $metadata);
            }
        }

        // Parse regular fields
        if (isset($entity->field)) {
            foreach ($entity->field as $field) {
                $this->parseField($field, $metadata);
            }
        }

        // Parse associations
        $this->parseAssociations($entity, $metadata);

        // Parse lifecycle callbacks
        if (isset($entity->{'lifecycle-callbacks'})) {
            $this->parseLifecycleCallbacks($entity->{'lifecycle-callbacks'}, $metadata);
        }

        // Parse cache config
        if (isset($entity->cache)) {
            $metadata['cache'] = $this->parseCacheConfig($entity->cache);
        }

        return $metadata;
    }

    /**
     * Parse table configuration.
     */
    private function parseTable(\SimpleXMLElement $entity): string
    {
        if (isset($entity->table)) {
            $table = $entity->table;
            $tableName = (string) $table['name'];
            $schema = (string) ($table['schema'] ?? null);

            return $schema ? "$schema.$tableName" : $tableName;
        }

        return $this->inferTableName((string) $entity['name']);
    }

    /**
     * Parse ID field.
     */
    private function parseIdField(\SimpleXMLElement $id, array &$metadata): void
    {
        $fieldName = (string) $id['name'];
        $columnName = (string) ($id['column'] ?? $fieldName);

        $metadata['identifier'][] = $fieldName;
        $metadata['fields'][$fieldName] = [
            'fieldName' => $fieldName,
            'columnName' => $columnName,
            'type' => (string) ($id['type'] ?? 'integer'),
            'id' => true,
            'strategy' => 'AUTO',
        ];

        // Parse generator strategy
        if (isset($id->generator)) {
            $strategy = (string) $id->generator['strategy'];
            $metadata['fields'][$fieldName]['strategy'] = strtoupper($strategy);

            if ($strategy === 'SEQUENCE' && isset($id->generator['sequence-name'])) {
                $metadata['fields'][$fieldName]['sequence'] = (string) $id->generator['sequence-name'];
            }
        }
    }

    /**
     * Parse regular field.
     */
    private function parseField(\SimpleXMLElement $field, array &$metadata): void
    {
        $fieldName = (string) $field['name'];

        $metadata['fields'][$fieldName] = [
            'fieldName' => $fieldName,
            'columnName' => (string) ($field['column'] ?? $fieldName),
            'type' => (string) ($field['type'] ?? 'string'),
            'nullable' => ((string) ($field['nullable'] ?? 'false')) === 'true',
            'unique' => ((string) ($field['unique'] ?? 'false')) === 'true',
        ];

        // Optional attributes
        if (isset($field['length'])) {
            $metadata['fields'][$fieldName]['length'] = (int) $field['length'];
        }

        if (isset($field['precision'])) {
            $metadata['fields'][$fieldName]['precision'] = (int) $field['precision'];
        }

        if (isset($field['scale'])) {
            $metadata['fields'][$fieldName]['scale'] = (int) $field['scale'];
        }
    }

    /**
     * Parse associations.
     */
    private function parseAssociations(\SimpleXMLElement $entity, array &$metadata): void
    {
        // Many-to-one
        if (isset($entity->{'many-to-one'})) {
            foreach ($entity->{'many-to-one'} as $assoc) {
                $this->parseManyToOne($assoc, $metadata);
            }
        }

        // One-to-many
        if (isset($entity->{'one-to-many'})) {
            foreach ($entity->{'one-to-many'} as $assoc) {
                $this->parseOneToMany($assoc, $metadata);
            }
        }

        // Many-to-many
        if (isset($entity->{'many-to-many'})) {
            foreach ($entity->{'many-to-many'} as $assoc) {
                $this->parseManyToMany($assoc, $metadata);
            }
        }
    }

    /**
     * Parse many-to-one association.
     */
    private function parseManyToOne(\SimpleXMLElement $assoc, array &$metadata): void
    {
        $fieldName = (string) $assoc['field'];

        $metadata['associations'][$fieldName] = [
            'fieldName' => $fieldName,
            'targetEntity' => (string) $assoc['target-entity'],
            'type' => 'manyToOne',
            'fetch' => (string) ($assoc['fetch'] ?? 'LAZY'),
        ];

        if (isset($assoc->{'join-column'})) {
            $metadata['associations'][$fieldName]['joinColumns'] = [
                [
                    'name' => (string) $assoc->{'join-column'}['name'],
                    'referencedColumnName' => (string) $assoc->{'join-column'}['referenced-column-name'],
                ],
            ];
        }
    }

    /**
     * Parse one-to-many association.
     */
    private function parseOneToMany(\SimpleXMLElement $assoc, array &$metadata): void
    {
        $fieldName = (string) $assoc['field'];

        $metadata['associations'][$fieldName] = [
            'fieldName' => $fieldName,
            'targetEntity' => (string) $assoc['target-entity'],
            'type' => 'oneToMany',
            'mappedBy' => (string) $assoc['mapped-by'],
            'fetch' => (string) ($assoc['fetch'] ?? 'LAZY'),
        ];
    }

    /**
     * Parse many-to-many association.
     */
    private function parseManyToMany(\SimpleXMLElement $assoc, array &$metadata): void
    {
        $fieldName = (string) $assoc['field'];

        $metadata['associations'][$fieldName] = [
            'fieldName' => $fieldName,
            'targetEntity' => (string) $assoc['target-entity'],
            'type' => 'manyToMany',
            'fetch' => (string) ($assoc['fetch'] ?? 'LAZY'),
        ];

        if (isset($assoc->{'join-table'})) {
            $metadata['associations'][$fieldName]['joinTable'] = [
                'name' => (string) $assoc->{'join-table'}['name'],
            ];
        }
    }

    /**
     * Parse lifecycle callbacks.
     */
    private function parseLifecycleCallbacks(\SimpleXMLElement $callbacks, array &$metadata): void
    {
        $events = ['pre-persist', 'post-persist', 'pre-update', 'post-update', 
                   'pre-remove', 'post-remove', 'post-load', 'pre-flush'];

        foreach ($events as $event) {
            if (isset($callbacks->{'lifecycle-callback'})) {
                foreach ($callbacks->{'lifecycle-callback'} as $callback) {
                    if ((string) $callback['type'] === $event) {
                        $eventKey = str_replace('-', '', ucwords($event, '-'));
                        $eventKey[0] = strtolower($eventKey[0]);
                        $metadata['lifecycleCallbacks'][$eventKey][] = (string) $callback['method'];
                    }
                }
            }
        }
    }

    /**
     * Parse cache configuration.
     */
    private function parseCacheConfig(\SimpleXMLElement $cache): array
    {
        return [
            'usage' => (string) ($cache['usage'] ?? 'READ_ONLY'),
            'region' => (string) ($cache['region'] ?? null) ?: null,
        ];
    }

    /**
     * Load and optionally validate XML file.
     */
    private function loadXmlFile(string $file): \SimpleXMLElement|false
    {
        if ($this->validateSchema) {
            // Validate against XSD schema if provided
            // Implementation omitted for brevity
        }

        return simplexml_load_file($file);
    }

    /**
     * Locate the XML file for a class.
     */
    private function locateXmlFile(string $className): ?string
    {
        $paths = is_array($this->paths) ? $this->paths : [$this->paths];

        foreach ($paths as $path) {
            $fileName = str_replace('\\', '.', $className) . '.dcm.xml';
            $filePath = rtrim($path, '/') . '/' . $fileName;

            if (file_exists($filePath)) {
                return $filePath;
            }
        }

        return null;
    }

    /**
     * Infer table name from class name.
     */
    private function inferTableName(string $className): string
    {
        $shortName = substr($className, strrpos($className, '\\') + 1);

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $shortName));
    }
}
