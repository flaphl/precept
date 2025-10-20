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
 * Simplified XML metadata driver.
 * Loads entity metadata from XML files with a simplified schema.
 */
class SimplifiedXmlDriver implements DriverInterface
{
    private array $loadedFiles = [];

    public function __construct(
        private readonly string|array $paths
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

        $xml = simplexml_load_file($xmlFile);

        if ($xml === false) {
            return [];
        }

        $metadata = [];

        foreach ($xml->entity as $entity) {
            $entityClass = (string) $entity['class'];
            $tableName = (string) ($entity['table'] ?? $this->inferTableName($entityClass));

            $entityMetadata = [
                'className' => $entityClass,
                'tableName' => $tableName,
                'repositoryClass' => (string) ($entity['repository-class'] ?? null) ?: null,
                'fields' => [],
                'associations' => [],
                'identifier' => [],
            ];

            // Parse fields
            foreach ($entity->field as $field) {
                $fieldName = (string) $field['name'];
                $entityMetadata['fields'][$fieldName] = [
                    'fieldName' => $fieldName,
                    'columnName' => (string) ($field['column'] ?? $fieldName),
                    'type' => (string) ($field['type'] ?? 'string'),
                    'nullable' => ((string) ($field['nullable'] ?? 'false')) === 'true',
                    'unique' => ((string) ($field['unique'] ?? 'false')) === 'true',
                    'length' => ($field['length'] ?? null) ? (int) $field['length'] : null,
                ];

                if (isset($field['id']) && (string) $field['id'] === 'true') {
                    $entityMetadata['identifier'][] = $fieldName;
                    $entityMetadata['fields'][$fieldName]['id'] = true;
                    $entityMetadata['fields'][$fieldName]['strategy'] = (string) ($field['strategy'] ?? 'AUTO');
                }
            }

            // Parse associations (simplified)
            foreach ($entity->{'many-to-one'} as $assoc) {
                $fieldName = (string) $assoc['field'];
                $entityMetadata['associations'][$fieldName] = [
                    'fieldName' => $fieldName,
                    'targetEntity' => (string) $assoc['target-entity'],
                    'type' => 'manyToOne',
                ];
            }

            $metadata[$entityClass] = $entityMetadata;
        }

        $this->loadedFiles[$xmlFile] = $metadata;

        return $metadata[$className] ?? [];
    }

    /**
     * Locate the XML file for a class.
     */
    private function locateXmlFile(string $className): ?string
    {
        $paths = is_array($this->paths) ? $this->paths : [$this->paths];

        foreach ($paths as $path) {
            $fileName = str_replace('\\', '.', $className) . '.xml';
            $filePath = rtrim($path, '/') . '/' . $fileName;

            if (file_exists($filePath)) {
                return $filePath;
            }

            // Try with just the class name
            $shortName = substr($className, strrpos($className, '\\') + 1);
            $filePath = rtrim($path, '/') . '/' . $shortName . '.xml';

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
