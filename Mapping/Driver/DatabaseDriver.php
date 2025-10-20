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
use Flaphl\Fridge\Precept\Connection\ConnectionInterface;

/**
 * Database-driven metadata loader.
 * Loads entity metadata by introspecting the database schema.
 */
class DatabaseDriver implements DriverInterface
{
    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly ?string $schema = null
    ) {
    }

    /**
     * Load metadata for a class by examining the database schema.
     */
    public function loadMetadataForClass(string $className): array
    {
        $tableName = $this->inferTableName($className);
        $columns = $this->getTableColumns($tableName);
        $primaryKeys = $this->getPrimaryKeys($tableName);
        $foreignKeys = $this->getForeignKeys($tableName);

        $metadata = [
            'className' => $className,
            'tableName' => $tableName,
            'fields' => [],
            'associations' => [],
            'identifier' => $primaryKeys,
        ];

        // Map columns to fields
        foreach ($columns as $column) {
            $metadata['fields'][$column['name']] = [
                'fieldName' => $column['name'],
                'columnName' => $column['name'],
                'type' => $this->mapDatabaseType($column['type']),
                'nullable' => $column['nullable'],
                'length' => $column['length'] ?? null,
                'id' => in_array($column['name'], $primaryKeys),
            ];
        }

        // Map foreign keys to associations
        foreach ($foreignKeys as $fk) {
            $metadata['associations'][$fk['column']] = [
                'fieldName' => $fk['column'],
                'targetEntity' => $this->inferClassName($fk['referenced_table']),
                'type' => 'manyToOne',
                'joinColumns' => [[
                    'name' => $fk['column'],
                    'referencedColumnName' => $fk['referenced_column'],
                ]],
            ];
        }

        return $metadata;
    }

    /**
     * Get all table columns.
     */
    private function getTableColumns(string $tableName): array
    {
        $driver = $this->connection->getDriver();

        return match ($driver) {
            'mysql' => $this->getMySQLColumns($tableName),
            'pgsql' => $this->getPostgreSQLColumns($tableName),
            'sqlite' => $this->getSQLiteColumns($tableName),
            default => [],
        };
    }

    /**
     * Get MySQL table columns.
     */
    private function getMySQLColumns(string $tableName): array
    {
        $sql = "SHOW COLUMNS FROM `$tableName`";
        $result = $this->connection->query($sql);

        return array_map(function ($row) {
            return [
                'name' => $row['Field'],
                'type' => $row['Type'],
                'nullable' => $row['Null'] === 'YES',
                'default' => $row['Default'],
            ];
        }, $result->fetchAll());
    }

    /**
     * Get PostgreSQL table columns.
     */
    private function getPostgreSQLColumns(string $tableName): array
    {
        $schema = $this->schema ?? 'public';
        $sql = "SELECT column_name, data_type, is_nullable, character_maximum_length
                FROM information_schema.columns
                WHERE table_schema = :schema AND table_name = :table";

        $result = $this->connection->query($sql, ['schema' => $schema, 'table' => $tableName]);

        return array_map(function ($row) {
            return [
                'name' => $row['column_name'],
                'type' => $row['data_type'],
                'nullable' => $row['is_nullable'] === 'YES',
                'length' => $row['character_maximum_length'],
            ];
        }, $result->fetchAll());
    }

    /**
     * Get SQLite table columns.
     */
    private function getSQLiteColumns(string $tableName): array
    {
        $sql = "PRAGMA table_info(`$tableName`)";
        $result = $this->connection->query($sql);

        return array_map(function ($row) {
            return [
                'name' => $row['name'],
                'type' => $row['type'],
                'nullable' => !$row['notnull'],
                'default' => $row['dflt_value'],
            ];
        }, $result->fetchAll());
    }

    /**
     * Get primary key columns.
     */
    private function getPrimaryKeys(string $tableName): array
    {
        // Implementation varies by driver
        return ['id']; // Simplified
    }

    /**
     * Get foreign key constraints.
     */
    private function getForeignKeys(string $tableName): array
    {
        // Implementation varies by driver
        return []; // Simplified
    }

    /**
     * Map database type to PHP type.
     */
    private function mapDatabaseType(string $dbType): string
    {
        return match (true) {
            str_contains(strtolower($dbType), 'int') => 'integer',
            str_contains(strtolower($dbType), 'varchar') => 'string',
            str_contains(strtolower($dbType), 'text') => 'text',
            str_contains(strtolower($dbType), 'decimal') => 'decimal',
            str_contains(strtolower($dbType), 'float') => 'float',
            str_contains(strtolower($dbType), 'bool') => 'boolean',
            str_contains(strtolower($dbType), 'date') => 'datetime',
            default => 'string',
        };
    }

    /**
     * Infer table name from class name.
     */
    private function inferTableName(string $className): string
    {
        $shortName = substr($className, strrpos($className, '\\') + 1);

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $shortName));
    }

    /**
     * Infer class name from table name.
     */
    private function inferClassName(string $tableName): string
    {
        $className = str_replace('_', '', ucwords($tableName, '_'));

        return 'App\\Entity\\' . $className;
    }
}
