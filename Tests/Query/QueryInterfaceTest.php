<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Query;

use Flaphl\Fridge\Precept\Query\QueryBuilderInterface;
use Flaphl\Fridge\Precept\Query\QueryInterface;
use PHPUnit\Framework\TestCase;

class QueryInterfaceTest extends TestCase
{
    public function testQueryBuilderInterfaceHasSelectMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('select'));
        $this->assertTrue($reflection->hasMethod('from'));
        $this->assertTrue($reflection->hasMethod('join'));
        $this->assertTrue($reflection->hasMethod('leftJoin'));
        $this->assertTrue($reflection->hasMethod('innerJoin'));
    }

    public function testQueryBuilderInterfaceHasWhereMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('where'));
        $this->assertTrue($reflection->hasMethod('andWhere'));
        $this->assertTrue($reflection->hasMethod('orWhere'));
    }

    public function testQueryBuilderInterfaceHasGroupingMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('groupBy'));
        $this->assertTrue($reflection->hasMethod('having'));
        $this->assertTrue($reflection->hasMethod('orderBy'));
    }

    public function testQueryBuilderInterfaceHasLimitMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setFirstResult'));
        $this->assertTrue($reflection->hasMethod('setMaxResults'));
    }

    public function testQueryBuilderInterfaceHasParameterMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setParameter'));
        $this->assertTrue($reflection->hasMethod('setParameters'));
    }

    public function testQueryBuilderInterfaceHasQueryGenerationMethods(): void
    {
        $reflection = new \ReflectionClass(QueryBuilderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getQuery'));
        $this->assertTrue($reflection->hasMethod('getResult'));
    }

    public function testQueryInterfaceHasExecutionMethods(): void
    {
        $reflection = new \ReflectionClass(QueryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('execute'));
        $this->assertTrue($reflection->hasMethod('getResult'));
        $this->assertTrue($reflection->hasMethod('getSingleResult'));
        $this->assertTrue($reflection->hasMethod('getSingleScalarResult'));
    }

    public function testQueryInterfaceHasParameterMethods(): void
    {
        $reflection = new \ReflectionClass(QueryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setParameter'));
        $this->assertTrue($reflection->hasMethod('setParameters'));
    }

    public function testQueryInterfaceHasHydrationMethods(): void
    {
        $reflection = new \ReflectionClass(QueryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setHydrationMode'));
    }

    public function testBothQueryInterfacesExist(): void
    {
        $this->assertTrue(interface_exists(QueryBuilderInterface::class));
        $this->assertTrue(interface_exists(QueryInterface::class));
    }
}
