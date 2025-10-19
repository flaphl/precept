<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Hydration;

use Flaphl\Fridge\Precept\Hydration\HydratorInterface;
use Flaphl\Fridge\Precept\Hydration\InstantiatorInterface;
use PHPUnit\Framework\TestCase;

class HydrationInterfaceTest extends TestCase
{
    public function testHydratorInterfaceHasHydrateMethods(): void
    {
        $reflection = new \ReflectionClass(HydratorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('hydrateAll'));
        $this->assertTrue($reflection->hasMethod('hydrateEntity'));
        $this->assertTrue($reflection->hasMethod('hydrateArray'));
        $this->assertTrue($reflection->hasMethod('hydrateScalar'));
    }

    public function testInstantiatorInterfaceHasInstantiateMethods(): void
    {
        $reflection = new \ReflectionClass(InstantiatorInterface::class);
        
        $this->assertTrue($reflection->hasMethod('instantiate'));
        $this->assertTrue($reflection->hasMethod('canInstantiate'));
    }

    public function testBothHydrationInterfacesExist(): void
    {
        $this->assertTrue(interface_exists(HydratorInterface::class));
        $this->assertTrue(interface_exists(InstantiatorInterface::class));
    }
}
