<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Cache;

use Flaphl\Fridge\Precept\Cache\DefaultCache;
use Flaphl\Fridge\Precept\Cache\Region;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class DefaultCacheTest extends TestCase
{
    private CacheItemPoolInterface $cachePool;
    private DefaultCache $cache;

    protected function setUp(): void
    {
        $this->cachePool = $this->createMock(CacheItemPoolInterface::class);
        $this->cache = new DefaultCache($this->cachePool, 3600);
    }

    public function testGetRegionCreatesDefaultRegion(): void
    {
        $region = $this->cache->getRegion('test_region');
        
        $this->assertInstanceOf(Region::class, $region);
    }

    public function testGetRegionReturnsSameInstanceForSameName(): void
    {
        $region1 = $this->cache->getRegion('test_region');
        $region2 = $this->cache->getRegion('test_region');
        
        $this->assertSame($region1, $region2);
    }

    public function testHasRegion(): void
    {
        $this->assertFalse($this->cache->hasRegion('test_region'));
        
        $this->cache->getRegion('test_region');
        
        $this->assertTrue($this->cache->hasRegion('test_region'));
    }

    public function testEvictRegion(): void
    {
        $region = $this->cache->getRegion('test_region');
        
        $this->assertTrue($this->cache->hasRegion('test_region'));
        
        $this->cache->evictRegion('test_region');
        
        $this->assertFalse($this->cache->hasRegion('test_region'));
    }

    public function testGetCachePool(): void
    {
        $pool = $this->cache->getCachePool();
        
        $this->assertSame($this->cachePool, $pool);
    }

    public function testGetStats(): void
    {
        $region = $this->cache->getRegion('test_region');
        
        $stats = $this->cache->getStats();
        
        $this->assertIsArray($stats);
        $this->assertArrayHasKey('test_region', $stats);
    }

    public function testClearRemovesAllRegions(): void
    {
        $this->cache->getRegion('region1');
        $this->cache->getRegion('region2');
        
        $this->cachePool->expects($this->atLeastOnce())
            ->method('clear');

        $this->cache->clear();
        
        // After clear, regions are removed
        $this->assertFalse($this->cache->hasRegion('region1'));
        $this->assertFalse($this->cache->hasRegion('region2'));
    }
}
