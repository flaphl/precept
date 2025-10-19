<?php

/**
 * This file is part of the Flaphl package.
 *
 * (c) Jade Phyressi <jade@flaphl.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flaphl\Fridge\Precept\Tests\Mapping;

use Flaphl\Fridge\Precept\Mapping\Id;
use PHPUnit\Framework\TestCase;

class IdAttributeTest extends TestCase
{
    public function testIdAttributeDefaults(): void
    {
        $id = new Id();
        
        $this->assertSame('auto', $id->strategy);
    }

    public function testIdAttributeWithAutoStrategy(): void
    {
        $id = new Id(strategy: 'auto');
        
        $this->assertSame('auto', $id->strategy);
    }

    public function testIdAttributeWithSequenceStrategy(): void
    {
        $id = new Id(strategy: 'sequence');
        
        $this->assertSame('sequence', $id->strategy);
    }

    public function testIdAttributeWithUuidStrategy(): void
    {
        $id = new Id(strategy: 'uuid');
        
        $this->assertSame('uuid', $id->strategy);
    }

    public function testIdAttributeWithNoneStrategy(): void
    {
        $id = new Id(strategy: 'none');
        
        $this->assertSame('none', $id->strategy);
    }
}
