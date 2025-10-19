<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Event;

use Flaphl\Fridge\Precept\Event\LifecycleEventInterface;
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
use PHPUnit\Framework\TestCase;

class LifecycleEventTest extends TestCase
{
    public function testAllLifecycleEventInterfacesExist(): void
    {
        $interfaces = [
            LifecycleEventInterface::class,
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
        ];
        
        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                sprintf('Interface %s does not exist', $interface)
            );
        }
    }

    public function testLifecycleEventInterfaceHasEntityMethod(): void
    {
        $reflection = new \ReflectionClass(LifecycleEventInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getEntity'));
        $this->assertTrue($reflection->hasMethod('getEntityClassName'));
    }

    public function testPreUpdateEventHasChangeSetMethods(): void
    {
        $reflection = new \ReflectionClass(PreUpdateEventInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getChangeSet'));
        $this->assertTrue($reflection->hasMethod('hasChangedField'));
        $this->assertTrue($reflection->hasMethod('getOldValue'));
        $this->assertTrue($reflection->hasMethod('getNewValue'));
        $this->assertTrue($reflection->hasMethod('setNewValue'));
    }

    public function testOnClearEventHasClearMethods(): void
    {
        $reflection = new \ReflectionClass(OnClearEventInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getEntityClass'));
        $this->assertTrue($reflection->hasMethod('clearsAllEntities'));
    }

    public function testAllPersistEventsExtendLifecycleEvent(): void
    {
        $events = [
            PrePersistEventInterface::class,
            PostPersistEventInterface::class,
        ];
        
        foreach ($events as $event) {
            $reflection = new \ReflectionClass($event);
            $interfaces = $reflection->getInterfaceNames();
            
            $this->assertContains(
                LifecycleEventInterface::class,
                $interfaces,
                sprintf('%s must extend LifecycleEventInterface', $event)
            );
        }
    }

    public function testAllUpdateEventsExtendLifecycleEvent(): void
    {
        $events = [
            PreUpdateEventInterface::class,
            PostUpdateEventInterface::class,
        ];
        
        foreach ($events as $event) {
            $reflection = new \ReflectionClass($event);
            $interfaces = $reflection->getInterfaceNames();
            
            $this->assertContains(
                LifecycleEventInterface::class,
                $interfaces,
                sprintf('%s must extend LifecycleEventInterface', $event)
            );
        }
    }

    public function testAllRemoveEventsExtendLifecycleEvent(): void
    {
        $events = [
            PreRemoveEventInterface::class,
            PostRemoveEventInterface::class,
        ];
        
        foreach ($events as $event) {
            $reflection = new \ReflectionClass($event);
            $interfaces = $reflection->getInterfaceNames();
            
            $this->assertContains(
                LifecycleEventInterface::class,
                $interfaces,
                sprintf('%s must extend LifecycleEventInterface', $event)
            );
        }
    }
}
