<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Schema;

use Flaphl\Fridge\Precept\Schema\SchemaManagerInterface;
use Flaphl\Fridge\Precept\Schema\TableInterface;
use Flaphl\Fridge\Precept\Schema\ColumnInterface;
use Flaphl\Fridge\Precept\Schema\IndexInterface;
use Flaphl\Fridge\Precept\Schema\ForeignKeyInterface;
use Flaphl\Fridge\Precept\Schema\TableDiffInterface;
use PHPUnit\Framework\TestCase;

class SchemaInterfaceTest extends TestCase
{
    public function testSchemaManagerInterfaceHasTableMethods(): void
    {
        $reflection = new \ReflectionClass(SchemaManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('createTable'));
        $this->assertTrue($reflection->hasMethod('alterTable'));
        $this->assertTrue($reflection->hasMethod('dropTable'));
        $this->assertTrue($reflection->hasMethod('tableExists'));
        $this->assertTrue($reflection->hasMethod('listTableNames'));
    }

    public function testSchemaManagerInterfaceHasColumnMethods(): void
    {
        $reflection = new \ReflectionClass(SchemaManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getTable'));
        $this->assertTrue($reflection->hasMethod('listTableColumns'));
    }

    public function testSchemaManagerInterfaceHasIndexMethods(): void
    {
        $reflection = new \ReflectionClass(SchemaManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('listTableIndexes'));
    }

    public function testSchemaManagerInterfaceHasForeignKeyMethods(): void
    {
        $reflection = new \ReflectionClass(SchemaManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('listTableForeignKeys'));
    }

    public function testTableInterfaceHasDefinitionMethods(): void
    {
        $reflection = new \ReflectionClass(TableInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('addColumn'));
        $this->assertTrue($reflection->hasMethod('addIndex'));
        $this->assertTrue($reflection->hasMethod('addForeignKey'));
        $this->assertTrue($reflection->hasMethod('setPrimaryKey'));
    }

    public function testTableInterfaceHasGetterMethods(): void
    {
        $reflection = new \ReflectionClass(TableInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getColumns'));
        $this->assertTrue($reflection->hasMethod('getIndexes'));
        $this->assertTrue($reflection->hasMethod('getForeignKeys'));
        $this->assertTrue($reflection->hasMethod('getPrimaryKey'));
    }

    public function testColumnInterfaceHasDefinitionMethods(): void
    {
        $reflection = new \ReflectionClass(ColumnInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('getType'));
        $this->assertTrue($reflection->hasMethod('getLength'));
        $this->assertTrue($reflection->hasMethod('isNullable'));
        $this->assertTrue($reflection->hasMethod('getDefault'));
    }

    public function testIndexInterfaceHasDefinitionMethods(): void
    {
        $reflection = new \ReflectionClass(IndexInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('getColumns'));
        $this->assertTrue($reflection->hasMethod('isUnique'));
        $this->assertTrue($reflection->hasMethod('isPrimary'));
    }

    public function testForeignKeyInterfaceHasDefinitionMethods(): void
    {
        $reflection = new \ReflectionClass(ForeignKeyInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getName'));
        $this->assertTrue($reflection->hasMethod('getLocalColumns'));
        $this->assertTrue($reflection->hasMethod('getForeignTableName'));
        $this->assertTrue($reflection->hasMethod('getForeignColumns'));
        $this->assertTrue($reflection->hasMethod('getOnDelete'));
        $this->assertTrue($reflection->hasMethod('getOnUpdate'));
    }

    public function testTableDiffInterfaceHasChangeTrackingMethods(): void
    {
        $reflection = new \ReflectionClass(TableDiffInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getAddedColumns'));
        $this->assertTrue($reflection->hasMethod('getRemovedColumns'));
        $this->assertTrue($reflection->hasMethod('getChangedColumns'));
        $this->assertTrue($reflection->hasMethod('getAddedIndexes'));
        $this->assertTrue($reflection->hasMethod('getRemovedIndexes'));
        $this->assertTrue($reflection->hasMethod('getAddedForeignKeys'));
        $this->assertTrue($reflection->hasMethod('getRemovedForeignKeys'));
    }

    public function testAllSchemaInterfacesExist(): void
    {
        $interfaces = [
            SchemaManagerInterface::class,
            TableInterface::class,
            ColumnInterface::class,
            IndexInterface::class,
            ForeignKeyInterface::class,
            TableDiffInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
