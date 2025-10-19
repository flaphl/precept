<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests;

use Flaphl\Fridge\Precept\Cache\ResultCacheInterface;
use Flaphl\Fridge\Precept\Cache\MetadataCacheInterface;
use Flaphl\Fridge\Precept\Cache\CacheConfigurationInterface;
use Flaphl\Fridge\Precept\Cache\CacheWarmerInterface;
use Flaphl\Fridge\Precept\Entity\EntityInterface;
use Flaphl\Fridge\Precept\Entity\EntityManagerInterface;
use Flaphl\Fridge\Precept\Entity\UnitOfWorkInterface;
use Flaphl\Fridge\Precept\Repository\RepositoryInterface;
use Flaphl\Fridge\Precept\Repository\RepositoryFactoryInterface;
use Flaphl\Fridge\Precept\Query\QueryBuilderInterface;
use Flaphl\Fridge\Precept\Query\QueryInterface;
use Flaphl\Fridge\Precept\Connection\ConnectionInterface;
use Flaphl\Fridge\Precept\Connection\ResultInterface;
use Flaphl\Fridge\Precept\Connection\StatementInterface;
use Flaphl\Fridge\Precept\Connection\PlatformInterface;
use Flaphl\Fridge\Precept\Schema\SchemaManagerInterface;
use Flaphl\Fridge\Precept\Schema\TableInterface;
use Flaphl\Fridge\Precept\Schema\ColumnInterface;
use Flaphl\Fridge\Precept\Schema\IndexInterface;
use Flaphl\Fridge\Precept\Schema\ForeignKeyInterface;
use Flaphl\Fridge\Precept\Schema\TableDiffInterface;
use Flaphl\Fridge\Precept\Event\EventDispatcherInterface;
use Flaphl\Fridge\Precept\Event\PrePersistEventInterface;
use Flaphl\Fridge\Precept\Event\PostPersistEventInterface;
use Flaphl\Fridge\Precept\Event\PreUpdateEventInterface;
use Flaphl\Fridge\Precept\Event\PostUpdateEventInterface;
use Flaphl\Fridge\Precept\Event\PreRemoveEventInterface;
use Flaphl\Fridge\Precept\Event\PostRemoveEventInterface;
use Flaphl\Fridge\Precept\Event\PostLoadEventInterface;
use Flaphl\Fridge\Precept\Event\PreFlushEventInterface;
use Flaphl\Fridge\Precept\Event\PostFlushEventInterface;
use Flaphl\Fridge\Precept\Event\OnClearEventInterface;
use Flaphl\Fridge\Precept\Hydration\HydratorInterface;
use Flaphl\Fridge\Precept\Hydration\InstantiatorInterface;
use Flaphl\Fridge\Precept\Metadata\MetadataInterface;
use Flaphl\Fridge\Precept\Metadata\MetadataFactoryInterface;
use Flaphl\Fridge\Precept\Metadata\DriverInterface;
use Flaphl\Fridge\Precept\Injection\ServiceProviderInterface;
use Flaphl\Fridge\Precept\Injection\ContainerAwareEntityManagerInterface;
use Flaphl\Fridge\Precept\Injection\EntityManagerFactoryInterface;
use Flaphl\Fridge\Precept\Injection\ContainerAwareRepositoryFactoryInterface;
use Flaphl\Fridge\Precept\DataCollector\DataCollectorInterface;
use Flaphl\Fridge\Precept\ScopeInterface;
use Flaphl\Contracts\Cache\TagAwareCacheInterface;
use PHPUnit\Framework\TestCase;

class InterfaceContractTest extends TestCase
{
    public function testAllInterfacesExist(): void
    {
        $interfaces = [
            // Cache
            ResultCacheInterface::class,
            MetadataCacheInterface::class,
            CacheConfigurationInterface::class,
            CacheWarmerInterface::class,
            
            // Entity
            EntityInterface::class,
            EntityManagerInterface::class,
            UnitOfWorkInterface::class,
            
            // Repository
            RepositoryInterface::class,
            RepositoryFactoryInterface::class,
            
            // Query
            QueryBuilderInterface::class,
            QueryInterface::class,
            
            // Connection
            ConnectionInterface::class,
            ResultInterface::class,
            StatementInterface::class,
            PlatformInterface::class,
            
            // Schema
            SchemaManagerInterface::class,
            TableInterface::class,
            ColumnInterface::class,
            IndexInterface::class,
            ForeignKeyInterface::class,
            TableDiffInterface::class,
            
            // Event
            EventDispatcherInterface::class,
            PrePersistEventInterface::class,
            PostPersistEventInterface::class,
            PreUpdateEventInterface::class,
            PostUpdateEventInterface::class,
            PreRemoveEventInterface::class,
            PostRemoveEventInterface::class,
            PostLoadEventInterface::class,
            PreFlushEventInterface::class,
            PostFlushEventInterface::class,
            OnClearEventInterface::class,
            
            // Hydration
            HydratorInterface::class,
            InstantiatorInterface::class,
            
            // Metadata
            MetadataInterface::class,
            MetadataFactoryInterface::class,
            DriverInterface::class,
            
            // Injection
            ServiceProviderInterface::class,
            ContainerAwareEntityManagerInterface::class,
            EntityManagerFactoryInterface::class,
            ContainerAwareRepositoryFactoryInterface::class,
            
            // DataCollector
            DataCollectorInterface::class,
            
            // Scope
            ScopeInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }

    public function testResultCacheExtendsTagAwareCache(): void
    {
        $reflection = new \ReflectionClass(ResultCacheInterface::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertContains(
            TagAwareCacheInterface::class,
            $interfaces,
            'ResultCacheInterface must extend TagAwareCacheInterface'
        );
    }

    public function testEventDispatcherExtendsPsrEventDispatcher(): void
    {
        $reflection = new \ReflectionClass(EventDispatcherInterface::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertContains(
            \Psr\EventDispatcher\EventDispatcherInterface::class,
            $interfaces,
            'EventDispatcherInterface must extend PSR-14 EventDispatcherInterface'
        );
    }

    public function testContainerAwareEntityManagerExtendsEntityManager(): void
    {
        $reflection = new \ReflectionClass(ContainerAwareEntityManagerInterface::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertContains(
            EntityManagerInterface::class,
            $interfaces,
            'ContainerAwareEntityManagerInterface must extend EntityManagerInterface'
        );
    }
}
