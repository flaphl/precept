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

use Flaphl\Fridge\Precept\Query\HydrationMode;
use PHPUnit\Framework\TestCase;

class HydrationModeTest extends TestCase
{
    public function testHydrationModeValues(): void
    {
        $this->assertSame('object', HydrationMode::OBJECT->value);
        $this->assertSame('array', HydrationMode::ARRAY->value);
        $this->assertSame('scalar', HydrationMode::SCALAR->value);
        $this->assertSame('single_scalar', HydrationMode::SINGLE_SCALAR->value);
    }

    public function testHydrationModeEnumCases(): void
    {
        $cases = HydrationMode::cases();
        
        $this->assertCount(4, $cases);
        $this->assertContains(HydrationMode::OBJECT, $cases);
        $this->assertContains(HydrationMode::ARRAY, $cases);
        $this->assertContains(HydrationMode::SCALAR, $cases);
        $this->assertContains(HydrationMode::SINGLE_SCALAR, $cases);
    }

    public function testHydrationModeFrom(): void
    {
        $this->assertSame(HydrationMode::OBJECT, HydrationMode::from('object'));
        $this->assertSame(HydrationMode::ARRAY, HydrationMode::from('array'));
        $this->assertSame(HydrationMode::SCALAR, HydrationMode::from('scalar'));
        $this->assertSame(HydrationMode::SINGLE_SCALAR, HydrationMode::from('single_scalar'));
    }

    public function testHydrationModeTryFrom(): void
    {
        $this->assertSame(HydrationMode::OBJECT, HydrationMode::tryFrom('object'));
        $this->assertNull(HydrationMode::tryFrom('INVALID'));
    }
}
