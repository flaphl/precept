<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Repository;

use Flaphl\Fridge\Precept\Repository\RepositoryInterface;
use Flaphl\Fridge\Precept\Repository\RepositoryFactoryInterface;
use PHPUnit\Framework\TestCase;

class RepositoryInterfaceTest extends TestCase
{
    public function testRepositoryInterfaceHasBasicFindMethods(): void
    {
        $reflection = new \ReflectionClass(RepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('find'));
        $this->assertTrue($reflection->hasMethod('findAll'));
        $this->assertTrue($reflection->hasMethod('findBy'));
        $this->assertTrue($reflection->hasMethod('findOneBy'));
    }

    public function testRepositoryInterfaceHasCountMethod(): void
    {
        $reflection = new \ReflectionClass(RepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('count'));
    }

    public function testRepositoryInterfaceHasQueryBuilderAccess(): void
    {
        $reflection = new \ReflectionClass(RepositoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('createQueryBuilder'));
        $this->assertTrue($reflection->hasMethod('getClassName'));
    }

    public function testRepositoryFactoryInterfaceHasCreateMethod(): void
    {
        $reflection = new \ReflectionClass(RepositoryFactoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('createRepository'));
    }

    public function testRepositoryInterfaceIsGeneric(): void
    {
        $reflection = new \ReflectionClass(RepositoryInterface::class);
        $docComment = $reflection->getDocComment();
        
        $this->assertStringContainsString('@template', $docComment);
        $this->assertStringContainsString('T of', $docComment);
    }
}
