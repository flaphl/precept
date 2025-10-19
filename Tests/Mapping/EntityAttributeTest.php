<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Mapping;

use Flaphl\Fridge\Precept\Mapping\Entity;
use PHPUnit\Framework\TestCase;

class EntityAttributeTest extends TestCase
{
    public function testEntityAttributeWithTableName(): void
    {
        $entity = new Entity(table: 'users');
        
        $this->assertSame('users', $entity->table);
        $this->assertNull($entity->repositoryClass);
        $this->assertFalse($entity->readOnly);
    }

    public function testEntityAttributeWithRepositoryClass(): void
    {
        $entity = new Entity(
            table: 'products',
            repositoryClass: 'App\\Repository\\ProductRepository'
        );
        
        $this->assertSame('products', $entity->table);
        $this->assertSame('App\\Repository\\ProductRepository', $entity->repositoryClass);
    }

    public function testEntityAttributeWithRepositoryAndReadOnly(): void
    {
        $entity = new Entity(
            table: 'logs',
            repositoryClass: 'App\\Repository\\LogRepository',
            readOnly: true
        );
        
        $this->assertSame('logs', $entity->table);
        $this->assertSame('App\\Repository\\LogRepository', $entity->repositoryClass);
        $this->assertTrue($entity->readOnly);
    }

    public function testEntityAttributeReadOnly(): void
    {
        $entity = new Entity(
            table: 'readonly_view',
            readOnly: true
        );
        
        $this->assertSame('readonly_view', $entity->table);
        $this->assertTrue($entity->readOnly);
    }

    public function testEntityAttributeAllParameters(): void
    {
        $entity = new Entity(
            table: 'orders',
            repositoryClass: 'App\\Repository\\OrderRepository',
            readOnly: false
        );
        
        $this->assertSame('orders', $entity->table);
        $this->assertSame('App\\Repository\\OrderRepository', $entity->repositoryClass);
        $this->assertFalse($entity->readOnly);
    }
}
