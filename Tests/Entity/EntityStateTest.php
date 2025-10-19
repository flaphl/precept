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

use Flaphl\Fridge\Precept\Entity\EntityState;
use PHPUnit\Framework\TestCase;

class EntityStateTest extends TestCase
{
    public function testEntityStateValues(): void
    {
        $this->assertSame('new', EntityState::NEW->value);
        $this->assertSame('managed', EntityState::MANAGED->value);
        $this->assertSame('detached', EntityState::DETACHED->value);
        $this->assertSame('removed', EntityState::REMOVED->value);
    }

    public function testEntityStateEnumCases(): void
    {
        $cases = EntityState::cases();
        
        $this->assertCount(4, $cases);
        $this->assertContains(EntityState::NEW, $cases);
        $this->assertContains(EntityState::MANAGED, $cases);
        $this->assertContains(EntityState::DETACHED, $cases);
        $this->assertContains(EntityState::REMOVED, $cases);
    }

    public function testEntityStateFrom(): void
    {
        $this->assertSame(EntityState::NEW, EntityState::from('new'));
        $this->assertSame(EntityState::MANAGED, EntityState::from('managed'));
        $this->assertSame(EntityState::DETACHED, EntityState::from('detached'));
        $this->assertSame(EntityState::REMOVED, EntityState::from('removed'));
    }

    public function testEntityStateTryFrom(): void
    {
        $this->assertSame(EntityState::NEW, EntityState::tryFrom('new'));
        $this->assertNull(EntityState::tryFrom('INVALID'));
    }
}
