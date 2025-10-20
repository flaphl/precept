<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Mapping\Builder;

use Flaphl\Fridge\Precept\Mapping\Builder\ClassMetaDataBuilder;
use Flaphl\Fridge\Precept\Mapping\Builder\FieldBuilder;
use Flaphl\Fridge\Precept\Mapping\Builder\OneToManyAssociationBuilder;
use Flaphl\Fridge\Precept\Mapping\Builder\ManyToManyAssociationBuilder;
use Flaphl\Fridge\Precept\Mapping\Builder\EntityListenerBuilder;
use Flaphl\Fridge\Precept\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;

class ClassMetaDataBuilderTest extends TestCase
{
    private ClassMetaDataBuilder $builder;
    private ClassMetadata $metadata;

    protected function setUp(): void
    {
        $this->metadata = new ClassMetadata('App\\Entity\\User');
        $this->builder = new ClassMetaDataBuilder($this->metadata);
    }

    public function testSetTable(): void
    {
        $this->builder->setTable('users');
        
        $this->assertSame('users', $this->metadata->getTableName());
    }

    public function testSetTableWithSchema(): void
    {
        $this->builder->setTable('users', 'public');
        
        $this->assertSame('users', $this->metadata->getTableName());
        $this->assertSame('public', $this->metadata->getSchemaName());
    }

    public function testAddField(): void
    {
        $fieldBuilder = $this->builder->addField('username', 'string');
        
        $this->assertInstanceOf(FieldBuilder::class, $fieldBuilder);
        $this->assertTrue($this->metadata->hasField('username'));
    }

    public function testSetIdentifier(): void
    {
        $this->builder->setIdentifier('id');
        
        $this->assertSame(['id'], $this->metadata->getIdentifier());
    }

    public function testSetCompositeIdentifier(): void
    {
        $this->builder->setIdentifier(['id', 'type']);
        
        $this->assertSame(['id', 'type'], $this->metadata->getIdentifier());
    }

    public function testAddOneToMany(): void
    {
        $builder = $this->builder->addOneToMany('posts', 'App\\Entity\\Post');
        
        $this->assertInstanceOf(OneToManyAssociationBuilder::class, $builder);
    }

    public function testAddManyToMany(): void
    {
        $builder = $this->builder->addManyToMany('roles', 'App\\Entity\\Role');
        
        $this->assertInstanceOf(ManyToManyAssociationBuilder::class, $builder);
    }

    public function testAddEntityListener(): void
    {
        $builder = $this->builder->addEntityListener('App\\Listener\\UserListener');
        
        $this->assertInstanceOf(EntityListenerBuilder::class, $builder);
    }

    public function testSetRepositoryClass(): void
    {
        $this->builder->setRepositoryClass('App\\Repository\\UserRepository');
        
        $this->assertSame('App\\Repository\\UserRepository', $this->metadata->customRepositoryClassName);
    }

    public function testEnableCache(): void
    {
        $this->builder->enableCache('READ_WRITE', 'users_cache');
        
        $this->assertTrue($this->metadata->isCacheable());
        $this->assertSame('READ_WRITE', $this->metadata->getCacheUsage());
        $this->assertSame('users_cache', $this->metadata->getCacheRegion());
    }

    public function testFluentInterface(): void
    {
        $result = $this->builder
            ->setTable('users')
            ->setIdentifier('id')
            ->setRepositoryClass('App\\Repository\\UserRepository');
        
        $this->assertSame($this->builder, $result);
    }

    public function testBuildReturnsMetadata(): void
    {
        $result = $this->builder
            ->setTable('users')
            ->setIdentifier('id')
            ->build();
        
        $this->assertSame($this->metadata, $result);
    }
}

class FieldBuilderTest extends TestCase
{
    private ClassMetadata $metadata;
    private FieldBuilder $builder;

    protected function setUp(): void
    {
        $this->metadata = new ClassMetadata('App\\Entity\\User');
        $this->builder = new FieldBuilder($this->metadata, 'username', 'string');
    }

    public function testSetLength(): void
    {
        $this->builder->length(255);
        
        $mapping = $this->metadata->getFieldMapping('username');
        $this->assertSame(255, $mapping['length']);
    }

    public function testSetNullable(): void
    {
        $this->builder->nullable(true);
        
        $mapping = $this->metadata->getFieldMapping('username');
        $this->assertTrue($mapping['nullable']);
    }

    public function testSetUnique(): void
    {
        $this->builder->unique(true);
        
        $mapping = $this->metadata->getFieldMapping('username');
        $this->assertTrue($mapping['unique']);
    }

    public function testSetColumnName(): void
    {
        $this->builder->columnName('user_name');
        
        $mapping = $this->metadata->getFieldMapping('username');
        $this->assertSame('user_name', $mapping['columnName']);
    }

    public function testSetPrecision(): void
    {
        $builder = new FieldBuilder($this->metadata, 'price', 'decimal');
        $builder->precision(10)->scale(2);
        
        $mapping = $this->metadata->getFieldMapping('price');
        $this->assertSame(10, $mapping['precision']);
        $this->assertSame(2, $mapping['scale']);
    }

    public function testFluentInterface(): void
    {
        $result = $this->builder
            ->length(100)
            ->nullable(false)
            ->unique(true);
        
        $this->assertInstanceOf(FieldBuilder::class, $result);
    }

    public function testBuildReturnsClassMetaDataBuilder(): void
    {
        $result = $this->builder->build();
        
        $this->assertInstanceOf(ClassMetaDataBuilder::class, $result);
    }
}

class OneToManyAssociationBuilderTest extends TestCase
{
    private ClassMetadata $metadata;
    private OneToManyAssociationBuilder $builder;

    protected function setUp(): void
    {
        $this->metadata = new ClassMetadata('App\\Entity\\User');
        $this->builder = new OneToManyAssociationBuilder(
            $this->metadata,
            'posts',
            'App\\Entity\\Post'
        );
    }

    public function testMappedBy(): void
    {
        $this->builder->mappedBy('author');
        
        $mapping = $this->metadata->getAssociationMapping('posts');
        $this->assertSame('author', $mapping['mappedBy']);
    }

    public function testCascade(): void
    {
        $this->builder->cascade(['persist', 'remove']);
        
        $mapping = $this->metadata->getAssociationMapping('posts');
        $this->assertSame(['persist', 'remove'], $mapping['cascade']);
    }

    public function testOrphanRemoval(): void
    {
        $this->builder->orphanRemoval(true);
        
        $mapping = $this->metadata->getAssociationMapping('posts');
        $this->assertTrue($mapping['orphanRemoval']);
    }

    public function testFetchMode(): void
    {
        $this->builder->fetch('EAGER');
        
        $mapping = $this->metadata->getAssociationMapping('posts');
        $this->assertSame('EAGER', $mapping['fetch']);
    }

    public function testOrderBy(): void
    {
        $this->builder->orderBy(['createdAt' => 'DESC']);
        
        $mapping = $this->metadata->getAssociationMapping('posts');
        $this->assertSame(['createdAt' => 'DESC'], $mapping['orderBy']);
    }

    public function testFluentInterface(): void
    {
        $result = $this->builder
            ->mappedBy('author')
            ->cascade(['persist'])
            ->orphanRemoval(true);
        
        $this->assertInstanceOf(OneToManyAssociationBuilder::class, $result);
    }
}

class ManyToManyAssociationBuilderTest extends TestCase
{
    private ClassMetadata $metadata;
    private ManyToManyAssociationBuilder $builder;

    protected function setUp(): void
    {
        $this->metadata = new ClassMetadata('App\\Entity\\User');
        $this->builder = new ManyToManyAssociationBuilder(
            $this->metadata,
            'roles',
            'App\\Entity\\Role'
        );
    }

    public function testSetJoinTable(): void
    {
        $this->builder->setJoinTable('user_roles');
        
        $mapping = $this->metadata->getAssociationMapping('roles');
        $this->assertSame('user_roles', $mapping['joinTable']['name']);
    }

    public function testSetJoinColumns(): void
    {
        $this->builder->setJoinColumns([
            ['name' => 'user_id', 'referencedColumnName' => 'id']
        ]);
        
        $mapping = $this->metadata->getAssociationMapping('roles');
        $this->assertCount(1, $mapping['joinTable']['joinColumns']);
    }

    public function testSetInverseJoinColumns(): void
    {
        $this->builder->setInverseJoinColumns([
            ['name' => 'role_id', 'referencedColumnName' => 'id']
        ]);
        
        $mapping = $this->metadata->getAssociationMapping('roles');
        $this->assertCount(1, $mapping['joinTable']['inverseJoinColumns']);
    }

    public function testMappedBy(): void
    {
        $this->builder->mappedBy('users');
        
        $mapping = $this->metadata->getAssociationMapping('roles');
        $this->assertSame('users', $mapping['mappedBy']);
    }

    public function testInversedBy(): void
    {
        $this->builder->inversedBy('users');
        
        $mapping = $this->metadata->getAssociationMapping('roles');
        $this->assertSame('users', $mapping['inversedBy']);
    }

    public function testFluentInterface(): void
    {
        $result = $this->builder
            ->setJoinTable('user_roles')
            ->inversedBy('users')
            ->cascade(['persist']);
        
        $this->assertInstanceOf(ManyToManyAssociationBuilder::class, $result);
    }
}
