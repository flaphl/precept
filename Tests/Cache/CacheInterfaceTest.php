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

use Flaphl\Fridge\Precept\Cache\ResultCacheInterface;
use Flaphl\Fridge\Precept\Cache\MetadataCacheInterface;
use Flaphl\Fridge\Precept\Cache\CacheConfigurationInterface;
use Flaphl\Fridge\Precept\Cache\CacheWarmerInterface;
use Flaphl\Contracts\Cache\TagAwareCacheInterface;
use PHPUnit\Framework\TestCase;

class CacheInterfaceTest extends TestCase
{
    public function testResultCacheInterfaceExtendsTagAwareCache(): void
    {
        $reflection = new \ReflectionClass(ResultCacheInterface::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertContains(
            TagAwareCacheInterface::class,
            $interfaces,
            'ResultCacheInterface must extend TagAwareCacheInterface'
        );
    }

    public function testResultCacheInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(ResultCacheInterface::class);
        
        $this->assertTrue($reflection->hasMethod('cacheResult'));
        $this->assertTrue($reflection->hasMethod('getCachedResult'));
        $this->assertTrue($reflection->hasMethod('hasCachedResult'));
        $this->assertTrue($reflection->hasMethod('cacheQuery'));
        $this->assertTrue($reflection->hasMethod('invalidateEntityCache'));
    }

    public function testMetadataCacheInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(MetadataCacheInterface::class);
        
        $this->assertTrue($reflection->hasMethod('cacheMetadata'));
        $this->assertTrue($reflection->hasMethod('getMetadata'));
        $this->assertTrue($reflection->hasMethod('hasMetadata'));
        $this->assertTrue($reflection->hasMethod('invalidateMetadata'));
        $this->assertTrue($reflection->hasMethod('warmUp'));
    }

    public function testCacheConfigurationInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(CacheConfigurationInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getResultCacheConfig'));
        $this->assertTrue($reflection->hasMethod('getMetadataCacheConfig'));
        $this->assertTrue($reflection->hasMethod('getQueryCacheConfig'));
        $this->assertTrue($reflection->hasMethod('isResultCacheEnabled'));
        $this->assertTrue($reflection->hasMethod('isMetadataCacheEnabled'));
        $this->assertTrue($reflection->hasMethod('isQueryCacheEnabled'));
        $this->assertTrue($reflection->hasMethod('setDefaultLifetime'));
        $this->assertTrue($reflection->hasMethod('getDefaultLifetime'));
    }

    public function testCacheWarmerInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(CacheWarmerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('warmUp'));
        $this->assertTrue($reflection->hasMethod('isEnabled'));
        $this->assertTrue($reflection->hasMethod('getStatistics'));
    }

    public function testAllCacheInterfacesExist(): void
    {
        $interfaces = [
            ResultCacheInterface::class,
            MetadataCacheInterface::class,
            CacheConfigurationInterface::class,
            CacheWarmerInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
