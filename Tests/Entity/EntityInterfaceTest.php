<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Entity;

use Flaphl\Fridge\Precept\Entity\EntityInterface;
use Flaphl\Fridge\Precept\Entity\EntityManagerInterface;
use Flaphl\Fridge\Precept\Entity\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;

class EntityInterfaceTest extends TestCase
{
    public function testEntityInterfaceHasIdentifierMethods(): void
    {
        $reflection = new \ReflectionClass(EntityInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getId'));
    }

    public function testEntityManagerInterfaceHasPersistenceMethods(): void
    {
        $reflection = new \ReflectionClass(EntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('persist'));
        $this->assertTrue($reflection->hasMethod('remove'));
        $this->assertTrue($reflection->hasMethod('flush'));
        $this->assertTrue($reflection->hasMethod('clear'));
    }

    public function testEntityManagerInterfaceHasFinderMethods(): void
    {
        $reflection = new \ReflectionClass(EntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('find'));
    }

    public function testEntityManagerInterfaceHasRepositoryMethods(): void
    {
        $reflection = new \ReflectionClass(EntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getRepository'));
    }

    public function testEntityManagerInterfaceHasTransactionMethods(): void
    {
        $reflection = new \ReflectionClass(EntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('beginTransaction'));
        $this->assertTrue($reflection->hasMethod('commit'));
        $this->assertTrue($reflection->hasMethod('rollback'));
    }

    public function testEntityManagerInterfaceHasUnitOfWorkAccess(): void
    {
        $reflection = new \ReflectionClass(EntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getUnitOfWork'));
    }

    public function testUnitOfWorkInterfaceHasEntityStateMethods(): void
    {
        $reflection = new \ReflectionClass(UnitOfWorkInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getEntityState'));
        $this->assertTrue($reflection->hasMethod('getScheduledInsertions'));
        $this->assertTrue($reflection->hasMethod('getScheduledUpdates'));
        $this->assertTrue($reflection->hasMethod('getScheduledDeletions'));
    }

    public function testUnitOfWorkInterfaceHasChangeTrackingMethods(): void
    {
        $reflection = new \ReflectionClass(UnitOfWorkInterface::class);
        
        $this->assertTrue($reflection->hasMethod('computeChangeSets'));
        $this->assertTrue($reflection->hasMethod('getEntityChangeSet'));
    }

    public function testUnitOfWorkInterfaceHasCommitMethods(): void
    {
        $reflection = new \ReflectionClass(UnitOfWorkInterface::class);
        
        $this->assertTrue($reflection->hasMethod('commit'));
        $this->assertTrue($reflection->hasMethod('clear'));
    }

    public function testAllEntityInterfacesExist(): void
    {
        $interfaces = [
            EntityInterface::class,
            EntityManagerInterface::class,
            UnitOfWorkInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
