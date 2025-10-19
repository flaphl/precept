<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Injection;

use Flaphl\Fridge\Precept\Injection\ServiceProviderInterface;
use Flaphl\Fridge\Precept\Injection\ContainerAwareEntityManagerInterface;
use Flaphl\Fridge\Precept\Injection\EntityManagerFactoryInterface;
use Flaphl\Fridge\Precept\Injection\ContainerAwareRepositoryFactoryInterface;
use Flaphl\Fridge\Precept\Entity\EntityManagerInterface;
use Flaphl\Fridge\Precept\Repository\RepositoryFactoryInterface;
use PHPUnit\Framework\TestCase;

class InjectionInterfaceTest extends TestCase
{
    public function testServiceProviderInterfaceHasRegistrationMethods(): void
    {
        $reflection = new \ReflectionClass(ServiceProviderInterface::class);
        
        $this->assertTrue($reflection->hasMethod('register'));
        $this->assertTrue($reflection->hasMethod('boot'));
        $this->assertTrue($reflection->hasMethod('provides'));
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

    public function testContainerAwareEntityManagerHasContainerMethods(): void
    {
        $reflection = new \ReflectionClass(ContainerAwareEntityManagerInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setContainer'));
        $this->assertTrue($reflection->hasMethod('getContainer'));
        $this->assertTrue($reflection->hasMethod('resolve'));
    }

    public function testEntityManagerFactoryInterfaceHasCreationMethods(): void
    {
        $reflection = new \ReflectionClass(EntityManagerFactoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('create'));
        $this->assertTrue($reflection->hasMethod('createNamed'));
        $this->assertTrue($reflection->hasMethod('getConfiguration'));
    }

    public function testContainerAwareRepositoryFactoryHasContainerMethods(): void
    {
        $reflection = new \ReflectionClass(ContainerAwareRepositoryFactoryInterface::class);
        
        $this->assertTrue($reflection->hasMethod('setContainer'));
        $this->assertTrue($reflection->hasMethod('createRepository'));
    }

    public function testAllInjectionInterfacesExist(): void
    {
        $interfaces = [
            ServiceProviderInterface::class,
            ContainerAwareEntityManagerInterface::class,
            EntityManagerFactoryInterface::class,
            ContainerAwareRepositoryFactoryInterface::class,
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }
}
