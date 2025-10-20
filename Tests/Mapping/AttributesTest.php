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

use Flaphl\Fridge\Precept\Mapping\{
    PrePersists, PostPersists, PreUpdate, PostUpdate,
    PreRemove, PostRemove, PreFlush, PostLoad,
    Table, JoinTable, Cache
};
use PHPUnit\Framework\TestCase;

class LifecycleAttributesTest extends TestCase
{
    public function testPrePersistAttribute(): void
    {
        $attribute = new PrePersists();
        
        $this->assertInstanceOf(PrePersists::class, $attribute);
    }

    public function testPostPersistAttribute(): void
    {
        $attribute = new PostPersists();
        
        $this->assertInstanceOf(PostPersists::class, $attribute);
    }

    public function testPreUpdateAttribute(): void
    {
        $attribute = new PreUpdate();
        
        $this->assertInstanceOf(PreUpdate::class, $attribute);
    }

    public function testPostUpdateAttribute(): void
    {
        $attribute = new PostUpdate();
        
        $this->assertInstanceOf(PostUpdate::class, $attribute);
    }

    public function testPreRemoveAttribute(): void
    {
        $attribute = new PreRemove();
        
        $this->assertInstanceOf(PreRemove::class, $attribute);
    }

    public function testPostRemoveAttribute(): void
    {
        $attribute = new PostRemove();
        
        $this->assertInstanceOf(PostRemove::class, $attribute);
    }

    public function testPreFlushAttribute(): void
    {
        $attribute = new PreFlush();
        
        $this->assertInstanceOf(PreFlush::class, $attribute);
    }

    public function testPostLoadAttribute(): void
    {
        $attribute = new PostLoad();
        
        $this->assertInstanceOf(PostLoad::class, $attribute);
    }

    public function testLifecycleAttributesOnClass(): void
    {
        $reflection = new \ReflectionClass(TestEntity::class);
        $methods = $reflection->getMethods();

        $prePersistMethods = [];
        $postLoadMethods = [];

        foreach ($methods as $method) {
            $attrs = $method->getAttributes(PrePersists::class);
            if (!empty($attrs)) {
                $prePersistMethods[] = $method->getName();
            }

            $attrs = $method->getAttributes(PostLoad::class);
            if (!empty($attrs)) {
                $postLoadMethods[] = $method->getName();
            }
        }

        $this->assertContains('beforePersist', $prePersistMethods);
        $this->assertContains('afterLoad', $postLoadMethods);
    }
}

class SchemaAttributesTest extends TestCase
{
    public function testTableAttribute(): void
    {
        $attribute = new Table(name: 'users', schema: 'public');
        
        $this->assertSame('users', $attribute->name);
        $this->assertSame('public', $attribute->schema);
    }

    public function testTableAttributeWithIndexes(): void
    {
        $attribute = new Table(
            name: 'users',
            indexes: [
                ['name' => 'idx_email', 'columns' => ['email']],
                ['name' => 'idx_username', 'columns' => ['username']]
            ]
        );
        
        $this->assertCount(2, $attribute->indexes);
        $this->assertSame('idx_email', $attribute->indexes[0]['name']);
    }

    public function testJoinTableAttribute(): void
    {
        $attribute = new JoinTable(
            name: 'user_roles',
            joinColumns: [['name' => 'user_id', 'referencedColumnName' => 'id']],
            inverseJoinColumns: [['name' => 'role_id', 'referencedColumnName' => 'id']]
        );
        
        $this->assertSame('user_roles', $attribute->name);
        $this->assertCount(1, $attribute->joinColumns);
        $this->assertCount(1, $attribute->inverseJoinColumns);
    }

    public function testCacheAttribute(): void
    {
        $attribute = new Cache(usage: 'READ_WRITE', region: 'user_cache');
        
        $this->assertSame('READ_WRITE', $attribute->usage);
        $this->assertSame('user_cache', $attribute->region);
    }

    public function testCacheAttributeDefaults(): void
    {
        $attribute = new Cache();
        
        $this->assertSame('READ_ONLY', $attribute->usage);
        $this->assertNull($attribute->region);
    }

    public function testSchemaAttributesOnClass(): void
    {
        $reflection = new \ReflectionClass(TestEntity::class);
        $attributes = $reflection->getAttributes(Table::class);

        $this->assertCount(1, $attributes);
        
        $table = $attributes[0]->newInstance();
        $this->assertSame('test_entities', $table->name);
    }
}

#[Table(name: 'test_entities')]
class TestEntity
{
    #[PrePersists]
    public function beforePersist(): void
    {
    }

    #[PostLoad]
    public function afterLoad(): void
    {
    }

    #[PreUpdate]
    public function beforeUpdate(): void
    {
    }
}
