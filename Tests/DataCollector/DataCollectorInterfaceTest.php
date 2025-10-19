<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\DataCollector;

use Flaphl\Fridge\Precept\DataCollector\DataCollectorInterface;
use PHPUnit\Framework\TestCase;

class DataCollectorInterfaceTest extends TestCase
{
    public function testDataCollectorInterfaceHasSetupMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setEntityManager'));
        $this->assertTrue($reflection->hasMethod('startCollection'));
        $this->assertTrue($reflection->hasMethod('stopCollection'));
        $this->assertTrue($reflection->hasMethod('isCollecting'));
        $this->assertTrue($reflection->hasMethod('reset'));
    }

    public function testDataCollectorInterfaceHasQueryMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getQueries'));
    }

    public function testDataCollectorInterfaceHasEntityMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getEntities'));
    }

    public function testDataCollectorInterfaceHasHydrationMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getHydrations'));
    }

    public function testDataCollectorInterfaceHasCacheMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getCacheStats'));
    }

    public function testDataCollectorInterfaceHasConnectionMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getConnectionInfo'));
    }

    public function testDataCollectorInterfaceHasMetadataMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getMetadata'));
    }

    public function testDataCollectorInterfaceHasUnitOfWorkMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getUnitOfWorkStats'));
    }

    public function testDataCollectorInterfaceHasPerformanceMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getPerformanceMetrics'));
    }

    public function testDataCollectorInterfaceHasDataAccessMethods(): void
    {
        $reflection = new \ReflectionClass(DataCollectorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getData'));
        $this->assertTrue($reflection->hasMethod('getName'));
    }

    public function testDataCollectorInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(DataCollectorInterface::class));
    }
}
