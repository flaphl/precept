<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Metadata;

use Flaphl\Fridge\Precept\Metadata\MetadataInterface;
use Flaphl\Fridge\Precept\Metadata\MetadataFactoryInterface;
use Flaphl\Fridge\Precept\Metadata\DriverInterface;
use PHPUnit\Framework\TestCase;

class MetadataInterfaceTest extends TestCase
{
    public function testMetadataInterfaceHasEntityInfoMethods(): void
    {
        $reflection = new \ReflectionClass(MetadataInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getClassName'));
        $this->assertTrue($reflection->hasMethod('getTableName'));
        $this->assertTrue($reflection->hasMethod('getIdentifierFieldNames'));
    }

    public function testMetadataInterfaceHasFieldMethods(): void
    {
        $reflection = new \ReflectionClass(MetadataInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getFieldMappings'));
        $this->assertTrue($reflection->hasMethod('getFieldMapping'));
        $this->assertTrue($reflection->hasMethod('hasField'));
    }

    public function testMetadataInterfaceHasAssociationMethods(): void
    {
        $reflection = new \ReflectionClass(MetadataInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getAssociationMappings'));
        $this->assertTrue($reflection->hasMethod('getAssociationMapping'));
        $this->assertTrue($reflection->hasMethod('hasAssociation'));
    }

    public function testMetadataFactoryInterfaceHasFactoryMethods(): void
    {
        $reflection = new \ReflectionClass(MetadataFactoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getMetadataFor'));
        $this->assertTrue($reflection->hasMethod('hasMetadataFor'));
        $this->assertTrue($reflection->hasMethod('getAllMetadata'));
    }

    public function testDriverInterfaceHasLoadMethods(): void
    {
        $reflection = new \ReflectionClass(DriverInterface::class);
        
        $this->assertTrue($reflection->hasMethod('loadMetadataForClass'));
        $this->assertTrue($reflection->hasMethod('getAllClassNames'));
    }

    public function testAllMetadataInterfacesExist(): void
    {
        $interfaces = [
            MetadataInterface::class,
            MetadataFactoryInterface::class,
            DriverInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
